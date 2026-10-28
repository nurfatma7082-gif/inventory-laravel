@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk & Persediaan')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Search Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Produk (SKU / Nama)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama atau SKU..."
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
            </div>

            <!-- Filter Kategori -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Filter Kategori</label>
                <select name="category_id" class="w-full py-2 px-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
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
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi Stok</label>
                <div class="flex items-center h-10 px-3 border border-slate-300 rounded-xl bg-slate-50">
                    <input type="checkbox" id="low_stock" name="low_stock" value="1" {{ $lowStock ? 'checked' : '' }}
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                    <label for="low_stock" class="text-xs text-slate-700 cursor-pointer select-none">Hanya Stok Menipis</label>
                </div>
            </div>

            <!-- Button Group -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition flex items-center justify-center space-x-1.5 shadow-sm">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Filter</span>
                </button>
                <a href="{{ route('products.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition flex items-center justify-center" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Main Products Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Daftar Produk Terdaftar</h4>
                <p class="text-xs text-slate-500">Menampilkan {{ $products->total() }} produk dalam inventaris.</p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('products.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-sm self-start sm:self-auto">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Produk Baru</span>
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">SKU</th>
                        <th class="px-6 py-3 font-semibold">Nama Produk</th>
                        <th class="px-6 py-3 font-semibold">Kategori</th>
                        <th class="px-6 py-3 font-semibold text-right">Harga Beli</th>
                        <th class="px-6 py-3 font-semibold text-right">Harga Jual</th>
                        <th class="px-6 py-3 font-semibold text-center">Stok Fisik</th>
                        <th class="px-6 py-3 font-semibold text-center">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $p)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-slate-700">{{ $p->sku }}</td>
                            <td class="px-6 py-3.5">
                                <a href="{{ route('products.show', $p->id) }}" class="font-medium text-slate-900 hover:text-indigo-600">
                                    {{ $p->name }}
                                </a>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="px-2.5 py-1 rounded-md text-xs bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $p->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right font-mono text-xs text-slate-600">
                                Rp {{ number_format($p->purchase_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3.5 text-right font-mono text-xs font-semibold text-slate-900">
                                Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                <span class="font-bold {{ $p->stock <= $p->minimum_stock ? 'text-amber-600' : 'text-slate-800' }}">
                                    {{ $p->stock }}
                                </span>
                                <span class="text-[11px] text-slate-400 block">Min: {{ $p->minimum_stock }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if($p->stock == 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-800">
                                        Habis
                                    </span>
                                @elseif($p->stock <= $p->minimum_stock)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800">
                                        Menipis
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Aman
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('products.show', $p->id) }}" class="p-1.5 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-indigo-50" title="Lihat Detail">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('products.edit', $p->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-blue-50" title="Edit Produk">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-rose-50" title="Hapus Produk">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500 text-sm">
                                <i class="fa-solid fa-inbox text-slate-300 text-3xl mb-2 block"></i>
                                Tidak ada produk yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
