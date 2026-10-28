<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases with filter, search, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $purchases = Purchase::with(['supplier', 'user', 'items'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('purchase_number', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function ($sq) use ($search) {
                          $sq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('purchased_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('purchased_at', '<=', $endDate);
            })
            ->latest('purchased_at')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact('purchases', 'search', 'status', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new purchase transaction.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase in storage.
     * Implements atomic DB::transaction, pessimistic locking (lockForUpdate), and automatic stock increment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchased_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ], [
            'supplier_id.required' => 'Pemasok / Supplier wajib dipilih.',
            'supplier_id.exists' => 'Pemasok tidak valid.',
            'purchased_at.required' => 'Tanggal pembelian wajib diisi.',
            'items.required' => 'Minimal harus menambahkan satu produk pada transaksi pembelian.',
            'items.min' => 'Minimal harus menambahkan satu produk pada transaksi pembelian.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.quantity.min' => 'Jumlah kuantitas pembelian minimal 1.',
            'items.*.unit_cost.min' => 'Harga beli satuan tidak boleh bernilai negatif.',
        ]);

        $purchase = DB::transaction(function () use ($request) {
            // 1. Generate nomor invoice unik
            $purchaseNumber = 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 2. Simpan header pembelian
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'purchase_number' => $purchaseNumber,
                'total' => 0,
                'status' => 'completed',
                'purchased_at' => $request->purchased_at,
                'notes' => $request->notes,
            ]);

            $total = 0;

            // 3. Simpan item & perbarui stok produk
            foreach ($request->items as $itemData) {
                // Gunakan lockForUpdate untuk menjaga konsistensi concurrency
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];
                $unitCost = (float) $itemData['unit_cost'];
                $subtotal = $qty * $unitCost;

                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                ]);

                // Stok otomatis bertambah saat pembelian berhasil
                $product->increment('stock', $qty);

                $total += $subtotal;
            }

            // 4. Update total nilai transaksi dihitung oleh server
            $purchase->update(['total' => $total]);

            return $purchase;
        });

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Transaksi pembelian ' . $purchase->purchase_number . ' berhasil disimpan dan stok produk telah diperbarui!');
    }

    /**
     * Display the specified purchase details.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.product.category']);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Cancel purchase transaction and rollback stock consistently (Admin only).
     */
    public function cancel(Purchase $purchase)
    {
        $this->authorize('cancel-transaction');

        if ($purchase->status === 'cancelled') {
            return back()->with('error', 'Transaksi pembelian ini sudah dalam status dibatalkan.');
        }

        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cancel' => "Gagal membatalkan transaksi: Stok produk '{$product->name}' tersisa {$product->stock}, tidak mencukupi untuk menarik kembali {$item->quantity} unit.",
                    ]);
                }

                // Kurangi kembali stok yang sebelumnya ditambahkan
                $product->decrement('stock', $item->quantity);
            }

            $purchase->update(['status' => 'cancelled']);
        });

        return redirect()->route('purchases.show', $purchase->id)
            ->with('success', 'Transaksi pembelian berhasil dibatalkan dan penambahan stok telah ditarik kembali secara konsisten.');
    }
}
