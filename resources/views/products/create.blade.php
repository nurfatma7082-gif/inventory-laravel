@extends('layouts.app')

@section('title', 'Tambah Produk Baru')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Formulir Master Produk</h4>
                <p class="text-xs text-slate-500">Isi data produk secara lengkap dan pastikan SKU bersifat unik.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-xs font-semibold text-slate-700 uppercase mb-1">SKU (Kode Unik Produk) <span class="text-rose-500">*</span></label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono"
                           placeholder="Contoh: PRD-ELK-001">
                    <p class="text-[11px] text-slate-400 mt-1">Harus unik di database, maksimal 50 karakter.</p>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Contoh: Mouse Wireless Logitech M170">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Harga Beli -->
                <div>
                    <label for="purchase_price" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Harga Beli / Modal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono"
                           placeholder="Contoh: 120000">
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="selling_price" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" min="0" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono"
                           placeholder="Contoh: 165000">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Stok Awal -->
                <div>
                    <label for="stock" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Stok Awal Fisik <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', 0) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                </div>

                <!-- Minimum Stock -->
                <div>
                    <label for="minimum_stock" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Batas Minimum Stok (Alert) <span class="text-rose-500">*</span></label>
                    <input type="number" min="0" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 5) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                    <p class="text-[11px] text-slate-400 mt-1">Sistem akan memberi sinyal alert jika stok &le; angka ini.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Produk</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
