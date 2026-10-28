@extends('layouts.app')

@section('title', 'Ubah Produk - ' . $product->name)
@section('page-title', 'Ubah Data Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Edit Informasi Produk</h4>
                <p class="text-xs text-slate-500">Perbarui rincian produk {{ $product->name }} (SKU: {{ $product->sku }}).</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-xs font-semibold text-slate-700 uppercase mb-1">SKU (Kode Unik Produk) <span class="text-rose-500">*</span></label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Harga Beli -->
                <div>
                    <label for="purchase_price" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Harga Beli / Modal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="selling_price" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Stok Fisik <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                    <p class="text-[11px] text-amber-600 mt-1">Catatan: Stok biasanya bertambah via Pembelian dan berkurang via Penjualan.</p>
                </div>

                <!-- Minimum Stock -->
                <div>
                    <label for="minimum_stock" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Batas Minimum Stok <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Perbarui Produk</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
