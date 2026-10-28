<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search, category filter, low-stock filter, and pagination.
     * Uses eager loading ('category') to avoid N+1 query problem.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $lowStock = $request->boolean('low_stock');

        $query = Product::with('category')
            ->when($search, function ($q, $search) {
                return $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($q, $categoryId) {
                return $q->where('category_id', $categoryId);
            })
            ->when($lowStock, function ($q) {
                return $q->lowStock();
            });

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'search', 'categoryId', 'lowStock'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.required' => 'SKU produk wajib diisi.',
            'sku.unique' => 'SKU ini sudah digunakan oleh produk lain.',
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'purchase_price.min' => 'Harga beli tidak boleh negatif.',
            'selling_price.min' => 'Harga jual tidak boleh negatif.',
            'stock.min' => 'Stok awal tidak boleh negatif.',
            'minimum_stock.min' => 'Batas minimum stok tidak boleh negatif.',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'purchaseItems.purchase.supplier', 'saleItems.sale.user']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.required' => 'SKU produk wajib diisi.',
            'sku.unique' => 'SKU ini sudah digunakan oleh produk lain.',
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'purchase_price.min' => 'Harga beli tidak boleh negatif.',
            'selling_price.min' => 'Harga jual tidak boleh negatif.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'minimum_stock.min' => 'Batas minimum stok tidak boleh negatif.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Business Rule: Jangan hard delete produk jika sudah dipakai dalam transaksi
        $hasPurchases = $product->purchaseItems()->count() > 0;
        $hasSales = $product->saleItems()->count() > 0;

        if ($hasPurchases || $hasSales) {
            // Gunakan soft delete agar relasi riwayat transaksi tetap terjaga
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Produk "' . $product->name . '" telah dinonaktifkan (soft deleted) untuk menjaga integritas riwayat transaksi.');
        }

        // Jika belum pernah digunakan, boleh di-force delete
        $product->forceDelete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus secara permanen.');
    }
}
