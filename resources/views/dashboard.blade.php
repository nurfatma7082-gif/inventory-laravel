@extends('layouts.app')

@section('title', 'Dashboard Estetik')
@section('page-title', 'Overview & Ringkasan Bisnis ✨')

@section('content')
<div class="space-y-7">

    <!-- Aesthetic Welcome Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-pink-500 via-rose-400 to-purple-500 rounded-3xl p-7 md:p-8 text-white shadow-xl shadow-pink-500/20">
        <!-- Cute decorative floating background blurs -->
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-white/20 blur-2xl pointer-events-none"></div>
        <div class="absolute right-36 -bottom-10 w-36 h-36 rounded-full bg-pink-300/30 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-1.5 max-w-xl">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/25 backdrop-blur-md text-white border border-white/30 shadow-xs mb-1">
                    🌸 Selamat Datang di StockFlow ✨
                </span>
                <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white drop-shadow-xs">
                    Halo, {{ Auth::user()->name }}! 💖
                </h3>
                <p class="text-pink-100 text-sm font-medium leading-relaxed">
                    Semua data stok barang dan transaksi kasir tercatat rapi secara real-time. Semangat beraktivitas yaa~! ✨
                </p>
            </div>

            <!-- Action Quick Buttons -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 px-5 py-3 bg-white text-pink-600 hover:bg-pink-50 rounded-2xl text-xs font-extrabold shadow-lg shadow-black/10 transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-cart-shopping text-sm text-pink-500"></i>
                    <span>Kasir Penjualan Baru</span>
                </a>
                <a href="{{ route('purchases.create') }}" class="inline-flex items-center space-x-2 px-5 py-3 bg-white/20 hover:bg-white/30 text-white rounded-2xl text-xs font-extrabold backdrop-blur-md border border-white/30 shadow-sm transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-truck-ramp-box text-sm"></i>
                    <span>Tambah Stok (PO)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Aesthetic Pastel Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Produk (Pastel Pink) -->
        <div class="bg-gradient-to-br from-pink-50/90 via-white to-rose-50/70 rounded-3xl p-5 border border-pink-200/70 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-pink-500 uppercase tracking-wider block">Total Produk</span>
                    <h4 class="text-2xl font-extrabold text-slate-800 mt-1 font-mono group-hover:text-pink-600 transition">
                        {{ number_format($totalProducts) }}
                    </h4>
                    <p class="text-[11px] font-semibold text-slate-400 mt-0.5">🌸 {{ $totalCategories }} Kategori aktif</p>
                </div>
                <div class="w-13 h-13 w-12 h-12 rounded-2xl bg-gradient-to-tr from-pink-400 to-rose-400 text-white flex items-center justify-center text-xl shadow-md shadow-pink-400/30 group-hover:scale-110 transition">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Stok Fisik (Pastel Lavender) -->
        <div class="bg-gradient-to-br from-purple-50/90 via-white to-indigo-50/70 rounded-3xl p-5 border border-purple-200/70 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-purple-500 uppercase tracking-wider block">Stok Tersedia</span>
                    <h4 class="text-2xl font-extrabold text-slate-800 mt-1 font-mono group-hover:text-purple-600 transition">
                        {{ number_format($totalStock) }} <span class="text-xs font-bold text-purple-400">unit</span>
                    </h4>
                    <p class="text-[11px] font-semibold text-slate-400 mt-0.5">📦 {{ $totalSuppliers }} Pemasok mitra</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-400 to-indigo-400 text-white flex items-center justify-center text-xl shadow-md shadow-purple-400/30 group-hover:scale-110 transition">
                    <i class="fa-solid fa-cube"></i>
                </div>
            </div>
        </div>

        <!-- Card 3: Penjualan Hari Ini (Pastel Mint) -->
        <div class="bg-gradient-to-br from-emerald-50/90 via-white to-teal-50/70 rounded-3xl p-5 border border-emerald-200/70 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Penjualan Hari Ini</span>
                    <h4 class="text-2xl font-extrabold text-slate-800 mt-1 font-mono group-hover:text-emerald-600 transition">
                        Rp {{ number_format($salesToday, 0, ',', '.') }}
                    </h4>
                    <p class="text-[11px] font-bold text-emerald-600 mt-0.5 flex items-center">
                        <i class="fa-regular fa-calendar-check text-[10px] mr-1"></i> {{ now()->format('d M Y') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-400 to-teal-400 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-400/30 group-hover:scale-110 transition">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>

        <!-- Card 4: Penjualan Bulan Ini (Pastel Peach/Coral) -->
        <div class="bg-gradient-to-br from-rose-50/90 via-white to-amber-50/70 rounded-3xl p-5 border border-rose-200/70 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-rose-500 uppercase tracking-wider block">Omzet Bulan Ini</span>
                    <h4 class="text-2xl font-extrabold text-slate-800 mt-1 font-mono group-hover:text-rose-600 transition">
                        Rp {{ number_format($salesThisMonth, 0, ',', '.') }}
                    </h4>
                    <p class="text-[11px] font-semibold text-slate-400 mt-0.5">✨ {{ $totalSalesCount }} transaksi selesai</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-rose-400 to-amber-400 text-white flex items-center justify-center text-xl shadow-md shadow-rose-400/30 group-hover:scale-110 transition">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Low-Stock Alert Section (Aesthetic Alert Card) -->
    <div class="bg-white/90 backdrop-blur-sm rounded-3xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4.5 border-b border-pink-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-rose-50/70 via-pink-50/50 to-white">
            <div class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-500 flex items-center justify-center text-base shadow-xs">
                    <i class="fa-solid fa-bell animate-bounce"></i>
                </span>
                <div>
                    <h4 class="font-bold text-slate-800 text-base flex items-center gap-1.5">
                        <span>Peringatan Stok Menipis</span>
                        <span class="text-xs">⚠️</span>
                    </h4>
                    <p class="text-xs text-slate-500">Produk yang stok fisiknya sudah menyentuh atau berada di bawah batas minimum.</p>
                </div>
            </div>
            <div>
                <span class="px-3.5 py-1.5 bg-rose-100/80 text-rose-700 font-extrabold text-xs rounded-full border border-rose-200 shadow-xs">
                    🚨 {{ $lowStockCount }} Produk Perlu Restock
                </span>
            </div>
        </div>

        @if($lowStockProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-pink-50/40 text-slate-500 text-xs uppercase border-b border-pink-100">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Kode SKU</th>
                            <th class="px-6 py-3.5 font-bold">Nama Produk</th>
                            <th class="px-6 py-3.5 font-bold">Kategori</th>
                            <th class="px-6 py-3.5 font-bold text-center">Sisa Stok</th>
                            <th class="px-6 py-3.5 font-bold text-center">Batas Min.</th>
                            <th class="px-6 py-3.5 font-bold text-right">Aksi Restock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50">
                        @foreach($lowStockProducts as $p)
                            <tr class="hover:bg-pink-50/40 transition">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-purple-600">{{ $p->sku }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $p->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                        {{ $p->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold {{ $p->stock == 0 ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $p->stock }} unit
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-slate-500">{{ $p->minimum_stock }} unit</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('purchases.create') }}" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white rounded-xl text-xs font-bold shadow-xs transition">
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
            <div class="p-10 text-center space-y-2">
                <span class="w-14 h-14 rounded-3xl bg-emerald-100 text-emerald-500 flex items-center justify-center text-2xl mx-auto shadow-xs">
                    <i class="fa-solid fa-face-smile-wink"></i>
                </span>
                <p class="font-bold text-slate-800 text-base">Semua Stok Produk Aman Terkendali! ✨</p>
                <p class="text-xs text-slate-400">Tidak ada produk yang berada di bawah ambang batas minimum saat ini.</p>
            </div>
        @endif
    </div>

    <!-- Recent Transactions Grid (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Penjualan Terkini Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl border border-pink-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4.5 border-b border-pink-100 flex items-center justify-between bg-gradient-to-r from-emerald-50/60 to-white">
                <div class="flex items-center space-x-2.5">
                    <span class="w-9 h-9 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm shadow-xs">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </span>
                    <h4 class="font-bold text-slate-800 text-base">Penjualan Terkini (Kasir)</h4>
                </div>
                <a href="{{ route('sales.index') }}" class="text-xs font-bold text-pink-600 hover:text-pink-700 flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-pink-50 text-sm">
                @forelse($recentSales as $sale)
                    <div class="p-4 hover:bg-pink-50/30 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('sales.show', $sale->id) }}" class="font-mono text-xs font-extrabold text-pink-600 hover:underline">
                                    {{ $sale->sale_number }}
                                </a>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $sale->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Kasir: <strong class="text-slate-700">{{ $sale->user->name ?? 'User' }}</strong> &bull; {{ $sale->sold_at->format('d M, H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-mono font-extrabold text-slate-800 block text-sm">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                            <a href="{{ route('sales.show', $sale->id) }}" class="text-[11px] font-bold text-pink-500 hover:text-pink-700">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">Belum ada transaksi penjualan tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Pengadaan Terkini Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl border border-pink-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4.5 border-b border-pink-100 flex items-center justify-between bg-gradient-to-r from-purple-50/60 to-white">
                <div class="flex items-center space-x-2.5">
                    <span class="w-9 h-9 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-sm shadow-xs">
                        <i class="fa-solid fa-dolly"></i>
                    </span>
                    <h4 class="font-bold text-slate-800 text-base">Pengadaan Stok (PO) Terkini</h4>
                </div>
                <a href="{{ route('purchases.index') }}" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-pink-50 text-sm">
                @forelse($recentPurchases as $purchase)
                    <div class="p-4 hover:bg-purple-50/30 flex items-center justify-between transition">
                        <div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="font-mono text-xs font-extrabold text-purple-600 hover:underline">
                                    {{ $purchase->purchase_number }}
                                </a>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $purchase->status === 'completed' ? 'bg-purple-100 text-purple-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Pemasok: <strong class="text-slate-700">{{ $purchase->supplier->name ?? 'Supplier' }}</strong> &bull; {{ $purchase->purchased_at->format('d M') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="font-mono font-extrabold text-slate-800 block text-sm">Rp {{ number_format($purchase->total, 0, ',', '.') }}</span>
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-[11px] font-bold text-purple-500 hover:text-purple-700">Detail &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">Belum ada transaksi pembelian tercatat.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
