@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk & Persediaan ✨')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Search Bar -->
    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-6 border border-pink-100 shadow-sm">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Produk (SKU / Nama) 🔍</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-pink-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama atau kode SKU..."
                           class="w-full pl-9 pr-3 py-2.5 text-sm rounded-2xl border border-pink-200 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none bg-pink-50/20">
                </div>
            </div>

            <!-- Filter Kategori -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Kategori 🏷️</label>
                <select name="category_id" class="w-full py-2.5 px-3 text-sm rounded-2xl border border-pink-200 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50/20">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Stok Menipis -->
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Stok ⚡</label>
                <div class="flex items-center h-11 px-3.5 border border-pink-200 rounded-2xl bg-pink-50/30">
                    <input type="checkbox" id="low_stock" name="low_stock" value="1" {{ $lowStock ? 'checked' : '' }}
                           class="rounded-lg border-pink-300 text-pink-500 focus:ring-pink-400 mr-2">
                    <label for="low_stock" class="text-xs font-semibold text-slate-700 cursor-pointer select-none">Hanya Stok Menipis</label>
                </div>
            </div>

            <!-- Button Group -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white rounded-2xl text-xs font-bold shadow-md shadow-pink-500/20 transition flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
                <a href="{{ route('products.index') }}" class="py-2.5 px-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl text-sm font-semibold transition flex items-center justify-center" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Main Products Table Card -->
    <div class="bg-white/90 backdrop-blur-sm rounded-3xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4.5 border-b border-pink-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-pink-50/50 to-white">
            <div>
                <h4 class="font-extrabold text-slate-800 text-base">Daftar Produk Inventaris</h4>
                <p class="text-xs text-slate-500">Tercatat {{ $products->total() }} produk aktif dalam sistem.</p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('products.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white rounded-2xl text-xs font-bold transition shadow-md shadow-pink-500/20 self-start sm:self-auto transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Produk Baru</span>
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-pink-50/30 text-slate-500 text-xs uppercase border-b border-pink-100">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Kode SKU</th>
                        <th class="px-6 py-3.5 font-bold">Nama Produk</th>
                        <th class="px-6 py-3.5 font-bold">Kategori</th>
                        <th class="px-6 py-3.5 font-bold text-right">Harga Beli</th>
                        <th class="px-6 py-3.5 font-bold text-right">Harga Jual</th>
                        <th class="px-6 py-3.5 font-bold text-center">Stok</th>
                        <th class="px-6 py-3.5 font-bold text-center">Kondisi</th>
                        <th class="px-6 py-3.5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50">
                    @forelse($products as $p)
                        <tr class="hover:bg-pink-50/40 transition">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-purple-600">{{ $p->sku }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <a href="{{ route('products.show', $p->id) }}" class="hover:text-pink-600 transition">
                                    {{ $p->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                    {{ $p->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-xs text-slate-600">
                                Rp {{ number_format($p->purchase_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-xs font-extrabold text-slate-900">
                                Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-extrabold font-mono {{ $p->stock <= $p->minimum_stock ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $p->stock }}
                                </span>
                                <span class="text-[10px] text-slate-400 block font-medium">Min: {{ $p->minimum_stock }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($p->stock == 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-red-100 text-red-700 border border-red-200">
                                        Habis
                                    </span>
                                @elseif($p->stock <= $p->minimum_stock)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                        Menipis
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Aman ✨
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('products.show', $p->id) }}" class="p-2 text-slate-500 hover:text-pink-600 rounded-xl hover:bg-pink-100/60 transition inline-block" title="Lihat Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('products.edit', $p->id) }}" class="p-2 text-slate-500 hover:text-purple-600 rounded-xl hover:bg-purple-100/60 transition inline-block" title="Edit Produk">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-rose-100/60 transition inline-block" title="Hapus Produk">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-box-open text-pink-300 text-4xl mb-2 block"></i>
                                Tidak ada produk yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-pink-100 bg-pink-50/20">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
