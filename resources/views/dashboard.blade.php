@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ══════════════════════════════════════════
         WELCOME HEADER BANNER
    ═══════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-violet-700 p-7 text-white shadow-lg">
        {{-- Subtle dot grid overlay --}}
        <div class="absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 22px 22px;"></div>
        {{-- Soft glow circle --}}
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div>
                <p class="text-indigo-200 text-xs font-semibold tracking-wider uppercase mb-1">
                    {{ now()->format('l, d F Y') }}
                </p>
                <h2 class="text-2xl font-extrabold tracking-tight text-white">
                    Selamat Datang, {{ Auth::user()->name }}
                </h2>
                <p class="text-indigo-200 text-sm mt-1 font-medium">
                    @if(Auth::user()->isAdmin())
                        Anda masuk sebagai <strong class="text-white">Administrator / Owner</strong> &mdash; akses penuh ke seluruh sistem.
                    @else
                        Anda masuk sebagai <strong class="text-white">Staff Kasir</strong> &mdash; kelola transaksi penjualan dan pembelian.
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('sales.create') }}"
                   class="inline-flex items-center space-x-2 px-5 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 rounded-xl text-xs font-bold shadow-md transition">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Transaksi Penjualan</span>
                </a>
                <a href="{{ route('purchases.create') }}"
                   class="inline-flex items-center space-x-2 px-5 py-2.5 bg-white/15 hover:bg-white/25 text-white rounded-xl text-xs font-bold border border-white/25 backdrop-blur-sm transition">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                    <span>Tambah Stok</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         4 METRIC CARDS
    ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Card 1: Total Produk --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Produk</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">{{ number_format($totalProducts) }}</p>
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">{{ $totalCategories }} kategori aktif</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1">
                    <span>Kelola Produk</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 2: Total Stok --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Tersedia</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">{{ number_format($totalStock) }}
                        <span class="text-sm font-semibold text-slate-400">unit</span>
                    </p>
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">{{ $totalSuppliers }} pemasok terdaftar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center text-lg group-hover:bg-violet-600 group-hover:text-white transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-violet-600 hover:text-violet-800 flex items-center space-x-1">
                    <span>Lihat Inventaris</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 3: Penjualan Hari Ini --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penjualan Hari Ini</p>
                    <p class="text-2xl font-extrabold text-slate-800 mt-2 font-mono">Rp {{ number_format($salesToday, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 mt-1.5 font-medium flex items-center space-x-1">
                        <i class="fa-regular fa-calendar-check text-[10px]"></i>
                        <span>{{ now()->format('d M Y') }}</span>
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('sales.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 flex items-center space-x-1">
                    <span>Riwayat Penjualan</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 4: Omzet Bulan Ini --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-5 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Omzet Bulan Ini</p>
                    <p class="text-2xl font-extrabold text-slate-800 mt-2 font-mono">Rp {{ number_format($salesThisMonth, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">{{ $totalSalesCount }} transaksi selesai</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('purchases.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-800 flex items-center space-x-1">
                    <span>Riwayat Pembelian</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         LOW STOCK ALERT TABLE
    ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        {{-- Section header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Peringatan Stok Menipis</h3>
                    <p class="text-xs text-slate-400 font-medium">Produk di bawah batas minimum stok</p>
                </div>
            </div>
            <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-[10px]"></i>
                <span>{{ $lowStockCount }} Produk Perlu Restock</span>
            </span>
        </div>

        @if($lowStockProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-bold">SKU</th>
                            <th class="px-6 py-3 font-bold">Nama Produk</th>
                            <th class="px-6 py-3 font-bold">Kategori</th>
                            <th class="px-6 py-3 font-bold text-center">Sisa Stok</th>
                            <th class="px-6 py-3 font-bold text-center">Batas Min</th>
                            <th class="px-6 py-3 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($lowStockProducts as $p)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3.5">
                                    <span class="font-mono text-xs font-bold text-indigo-600">{{ $p->sku }}</span>
                                </td>
                                <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $p->name }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600">
                                        {{ $p->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-extrabold
                                        {{ $p->stock == 0
                                            ? 'bg-red-100 text-red-700 border border-red-200'
                                            : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                        {{ $p->stock }} unit
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500">{{ $p->minimum_stock }} unit</td>
                                <td class="px-6 py-3.5 text-right">
                                    @can('manage-purchases')
                                    <a href="{{ route('purchases.create') }}"
                                       class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Restock</span>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-10 text-center">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-500 flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <p class="font-bold text-slate-700 text-sm">Semua Stok Produk Aman</p>
                <p class="text-xs text-slate-400 mt-1">Tidak ada produk di bawah batas minimum stok saat ini.</p>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════
         RECENT TRANSACTIONS — 2 COLUMNS
    ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Penjualan Terkini --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Penjualan Terkini</h3>
                </div>
                <a href="{{ route('sales.index') }}"
                   class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1 transition">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentSales as $sale)
                    <div class="px-6 py-3.5 hover:bg-slate-50/70 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('sales.show', $sale->id) }}"
                                   class="font-mono text-xs font-extrabold text-indigo-600 hover:underline">
                                    {{ $sale->sale_number }}
                                </a>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                                    {{ $sale->status === 'completed'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium">
                                Kasir: <strong class="text-slate-600">{{ $sale->user->name ?? '-' }}</strong>
                                &bull; {{ $sale->sold_at->format('d M, H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-mono font-extrabold text-slate-800 text-sm">Rp {{ number_format($sale->total, 0, ',', '.') }}</p>
                            <a href="{{ route('sales.show', $sale->id) }}"
                               class="text-[11px] font-bold text-indigo-500 hover:text-indigo-700">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-receipt text-slate-300 text-2xl mb-2 block"></i>
                        Belum ada transaksi penjualan.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pembelian Terkini --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-dolly"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Pengadaan Stok (PO)</h3>
                </div>
                <a href="{{ route('purchases.index') }}"
                   class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1 transition">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentPurchases as $purchase)
                    <div class="px-6 py-3.5 hover:bg-slate-50/70 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('purchases.show', $purchase->id) }}"
                                   class="font-mono text-xs font-extrabold text-violet-600 hover:underline">
                                    {{ $purchase->purchase_number }}
                                </a>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                                    {{ $purchase->status === 'completed'
                                        ? 'bg-violet-100 text-violet-700'
                                        : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5 font-medium">
                                Pemasok: <strong class="text-slate-600">{{ $purchase->supplier->name ?? '-' }}</strong>
                                &bull; {{ $purchase->purchased_at->format('d M') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-mono font-extrabold text-slate-800 text-sm">Rp {{ number_format($purchase->total, 0, ',', '.') }}</p>
                            <a href="{{ route('purchases.show', $purchase->id) }}"
                               class="text-[11px] font-bold text-violet-500 hover:text-violet-700">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-slate-400 text-xs">
                        <i class="fa-solid fa-truck text-slate-300 text-2xl mb-2 block"></i>
                        Belum ada transaksi pembelian.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
