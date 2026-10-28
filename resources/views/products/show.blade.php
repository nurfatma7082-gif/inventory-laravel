@extends('layouts.app')

@section('title', 'Detail Produk - ' . $product->name)
@section('page-title', 'Detail & Riwayat Produk')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-1.5 text-sm font-semibold text-slate-600 hover:text-slate-900">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Produk</span>
        </a>
        @if(Auth::user()->isAdmin())
            <div class="flex items-center space-x-2">
                <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Data</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Product Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 pb-6 border-b border-slate-100">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $product->sku }}
                    </span>
                    <span class="px-2.5 py-1 rounded-md text-xs bg-indigo-50 text-indigo-700 border border-indigo-100 font-medium">
                        {{ $product->category->name ?? '-' }}
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mt-2">{{ $product->name }}</h3>
                <p class="text-xs text-slate-400 mt-1">ID Produk: #{{ $product->id }} &bull; Dibuat pada {{ $product->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Stock Status Badge Card -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center min-w-[200px]">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ketersediaan Stok</p>
                <div class="text-3xl font-extrabold mt-1 {{ $product->stock <= $product->minimum_stock ? 'text-amber-600' : 'text-slate-800' }}">
                    {{ $product->stock }} <span class="text-xs font-normal text-slate-500">unit</span>
                </div>
                <div class="mt-2">
                    @if($product->stock == 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                            Stok Habis
                        </span>
                    @elseif($product->stock <= $product->minimum_stock)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                            Stok Menipis (&le; {{ $product->minimum_stock }})
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            Stok Aman
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Price Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-xs text-slate-500 uppercase font-semibold">Harga Beli Terakhir</p>
                <p class="text-lg font-bold text-slate-800 font-mono mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-xs text-slate-500 uppercase font-semibold">Harga Jual Satuan</p>
                <p class="text-lg font-bold text-indigo-600 font-mono mt-1">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-xs text-slate-500 uppercase font-semibold">Margin Keuntungan</p>
                @php
                    $margin = $product->selling_price - $product->purchase_price;
                    $marginPct = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
                @endphp
                <p class="text-lg font-bold text-emerald-600 font-mono mt-1">
                    Rp {{ number_format($margin, 0, ',', '.') }} 
                    <span class="text-xs font-normal text-emerald-700">({{ number_format($marginPct, 1) }}%)</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Related Transactions Tabs/Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Riwayat Pembelian (Stock-in) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h4 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-truck-ramp-box text-indigo-600"></i>
                    <span>Riwayat Pengadaan (Stock-In)</span>
                </h4>
                <span class="text-xs text-slate-500">{{ $product->purchaseItems->count() }} Transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-2.5">No. PO</th>
                            <th class="px-4 py-2.5">Tanggal</th>
                            <th class="px-4 py-2.5 text-center">Qty</th>
                            <th class="px-4 py-2.5 text-right">Harga Beli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($product->purchaseItems as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 font-mono">
                                    <a href="{{ route('purchases.show', $item->purchase_id) }}" class="text-indigo-600 hover:underline">
                                        {{ $item->purchase->purchase_number ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-4 py-2.5 text-slate-500">{{ $item->purchase->purchased_at->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-center font-bold text-emerald-700">+{{ $item->quantity }}</td>
                                <td class="px-4 py-2.5 text-right font-mono">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat pembelian untuk produk ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Penjualan (Stock-out) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h4 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-cash-register text-emerald-600"></i>
                    <span>Riwayat Penjualan (Stock-Out)</span>
                </h4>
                <span class="text-xs text-slate-500">{{ $product->saleItems->count() }} Transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-2.5">No. Inv</th>
                            <th class="px-4 py-2.5">Tanggal</th>
                            <th class="px-4 py-2.5 text-center">Qty</th>
                            <th class="px-4 py-2.5 text-right">Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($product->saleItems as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 font-mono">
                                    <a href="{{ route('sales.show', $item->sale_id) }}" class="text-indigo-600 hover:underline">
                                        {{ $item->sale->sale_number ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-4 py-2.5 text-slate-500">{{ $item->sale->sold_at->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-2.5 text-center font-bold text-rose-700">-{{ $item->quantity }}</td>
                                <td class="px-4 py-2.5 text-right font-mono">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat penjualan untuk produk ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
