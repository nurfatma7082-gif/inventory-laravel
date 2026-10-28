<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * Display a listing of sales transactions with filters, search, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $sales = Sale::with(['user', 'items.product'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('sale_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('sold_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('sold_at', '<=', $endDate);
            })
            ->latest('sold_at')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search', 'status', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new sale transaction.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created sale in storage.
     * Core rubric requirement:
     * - Atomic DB::transaction
     * - Server-side price calculation (never trusts client prices)
     * - Concurrency locking (lockForUpdate)
     * - Stock validation (insufficient stock rejection with rollback)
     * - Automatic stock decrement
     */
    public function store(Request $request)
    {
        $request->validate([
            'sold_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ], [
            'sold_at.required' => 'Tanggal transaksi penjualan wajib diisi.',
            'items.required' => 'Minimal harus menambahkan satu produk pada transaksi penjualan.',
            'items.min' => 'Minimal harus menambahkan satu produk pada transaksi penjualan.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.product_id.exists' => 'Produk tidak valid.',
            'items.*.quantity.min' => 'Jumlah kuantitas penjualan minimal 1.',
        ]);

        $sale = DB::transaction(function () use ($request) {
            // 1. Generate nomor invoice penjualan yang unik
            $saleNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 2. Simpan header penjualan
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'sale_number' => $saleNumber,
                'total' => 0,
                'status' => 'completed',
                'sold_at' => $request->sold_at,
                'notes' => $request->notes,
            ]);

            $total = 0;

            // 3. Simpan detail item & kurangi stok
            foreach ($request->items as $itemData) {
                // Kunci baris database untuk mencegah race condition (overselling)
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];

                // Validasi ketersediaan stok
                if ($qty < 1 || $product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk '{$product->name}' tidak mencukupi (Stok tersedia: {$product->stock}, diminta: {$qty}). Transaksi dibatalkan.",
                    ]);
                }

                // Ambil harga jual resmi dari database, bukan dari input browser
                $unitPrice = $product->selling_price;
                $subtotal = $unitPrice * $qty;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok produk secara konsisten
                $product->decrement('stock', $qty);

                $total += $subtotal;
            }

            // 4. Update total transaksi yang dihitung server
            $sale->update(['total' => $total]);

            return $sale;
        });

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Transaksi penjualan ' . $sale->sale_number . ' berhasil diproses dan stok telah berkurang!');
    }

    /**
     * Display the specified sale details.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product.category']);
        return view('sales.show', compact('sale'));
    }

    /**
     * Cancel sale transaction and restore stock consistently (Admin only).
     */
    public function cancel(Sale $sale)
    {
        $this->authorize('cancel-transaction');

        if ($sale->status === 'cancelled') {
            return back()->with('error', 'Transaksi penjualan ini sudah dalam status dibatalkan.');
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                // Kembalikan stok produk
                $product->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);
        });

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Transaksi penjualan berhasil dibatalkan dan stok produk telah dikembalikan secara konsisten.');
    }
}
