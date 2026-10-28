@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')
@section('page-title', 'Ringkasan & Analisis Bisnis')

@section('content')
<div class="space-y-6">

    <!-- Greeting Banner -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-600 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-indigo-100 text-sm mt-1">
                Selamat datang di sistem manajemen stok dan transaksi penjualan terintegrasi.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow-md transition">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Transaksi Penjualan Baru</span>
            </a>
            <a href="{{ route('purchases.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-xl text-sm font-semibold backdrop-blur-md transition">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Stok (PO)</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Produk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Produk</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalProducts) }}</h4>
                <p class="text-xs text-slate-400 mt-0.5">{{ $totalCategories }} Kategori terdaftar</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <!-- Total Unit Stok Fisik -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Stok Tersedia</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalStock) }} <span class="text-xs font-normal text-slate-500">unit</span></h4>
                <p class="text-xs text-slate-400 mt-0.5">{{ $totalSuppliers }} Pemasok aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-cubes"></i>
            </div>
        </div>

        <!-- Penjualan Hari Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Penjualan Hari Ini</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($salesToday, 0, ',', '.') }}</h4>
                <p class="text-xs text-emerald-600 font-medium mt-0.5">
                    <i class="fa-solid fa-calendar-day mr-1"></i> {{ now()->format('d M Y') }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-cash-register"></i>
            </div>
        </div>

        <!-- Penjualan Bulan Ini -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Penjualan Bulan Ini</p>
                <h4 class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($salesThisMonth, 0, ',', '.') }}</h4>
                <p class="text-xs text-slate-400 mt-0.5">{{ $totalSalesCount }} transaksi sukses</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Low-Stock Alert Section -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-amber-50/50">
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-base">Peringatan Stok Rendah (Low-Stock Alert)</h4>
                    <p class="text-xs text-slate-500">Produk yang berada pada atau di bawah batas minimum stok yang harus segera dilakukan restock.</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 font-bold text-xs rounded-full border border-amber-200">
                {{ $lowStockCount }} Produk Menipis
            </span>
        </div>

        @if($lowStockProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">SKU</th>
                            <th class="px-6 py-3 font-semibold">Nama Produk</th>
                            <th class="px-6 py-3 font-semibold">Kategori</th>
                            <th class="px-6 py-3 font-semibold text-center">Stok Saat Ini</th>
                            <th class="px-6 py-3 font-semibold text-center">Min. Stok</th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($lowStockProducts as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-3.5 font-mono text-xs text-slate-600 font-bold">{{ $p->sku }}</td>
                                <td class="px-6 py-3.5 font-medium text-slate-900">{{ $p->name }}</td>
                                <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $p->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $p->stock }} unit
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-center text-xs text-slate-500">{{ $p->minimum_stock }} unit</td>
                                <td class="px-6 py-3.5 text-right">
                                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center space-x-1 text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                                        <i class="fa-solid fa-cart-flatbed"></i>
                                        <span>Restock via PO</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-slate-500 text-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-3xl mb-2"></i>
                <p class="font-medium text-slate-700">Semua stok produk dalam kondisi aman!</p>
                <p class="text-xs text-slate-400">Tidak ada produk yang berada di bawah ambang batas minimum.</p>
            </div>
        @endif
    </div>

    <!-- Recent Transactions Grid (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Penjualan Terakhir -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-receipt"></i>
                    </span>
                    <h4 class="font-bold text-slate-800 text-base">Penjualan Terkini</h4>
                </div>
                <a href="{{ route('sales.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100 text-sm">
                @forelse($recentSales as $sale)
                    <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('sales.show', $sale->id) }}" class="font-mono text-xs font-bold text-indigo-600 hover:underline">
                                    {{ $sale->sale_number }}
                                </a>
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $sale->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Kasir: {{ $sale->user->name ?? 'User' }} &bull; {{ $sale->sold_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-900 block">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                            <a href="{{ route('sales.show', $sale->id) }}" class="text-xs text-slate-400 hover:text-slate-600">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada transaksi penjualan tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Pembelian Terakhir -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-truck-loading"></i>
                    </span>
                    <h4 class="font-bold text-slate-800 text-base">Pengadaan (PO) Terkini</h4>
                </div>
                <a href="{{ route('purchases.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100 text-sm">
                @forelse($recentPurchases as $purchase)
                    <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="font-mono text-xs font-bold text-indigo-600 hover:underline">
                                    {{ $purchase->purchase_number }}
                                </a>
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $purchase->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Pemasok: {{ $purchase->supplier->name ?? 'Supplier' }} &bull; {{ $purchase->purchased_at->format('d M Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-900 block">Rp {{ number_format($purchase->total, 0, ',', '.') }}</span>
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-xs text-slate-400 hover:text-slate-600">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada transaksi pembelian tercatat.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
