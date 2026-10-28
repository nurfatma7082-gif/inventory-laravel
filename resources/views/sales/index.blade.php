@extends('layouts.app')

@section('title', 'Transaksi Penjualan (Stock-Out)')
@section('page-title', 'Riwayat Transaksi Penjualan Kasir')

@section('content')
<div class="space-y-6">

    <!-- Filter & Action Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('sales.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari No. Faktur / Kasir</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Contoh: INV-2026 atau Nama Kasir..."
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Transaksi</label>
                <select name="status" class="w-full py-2 px-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="w-full py-2 px-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- End Date & Buttons -->
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                           class="w-full py-2 px-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div class="flex items-end gap-1">
                    <button type="submit" class="py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition" title="Filter">
                        <i class="fa-solid fa-filter text-xs"></i>
                    </button>
                    <a href="{{ route('sales.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition" title="Reset">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Sales Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Daftar Penjualan</h4>
                <p class="text-xs text-slate-500">Total {{ $sales->total() }} transaksi penjualan kasir.</p>
            </div>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-sm self-start sm:self-auto">
                <i class="fa-solid fa-cart-shopping text-xs"></i>
                <span>Transaksi Penjualan Baru</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">No. Faktur (Invoice)</th>
                        <th class="px-6 py-3 font-semibold">Kasir / Petugas</th>
                        <th class="px-6 py-3 font-semibold">Waktu Penjualan</th>
                        <th class="px-6 py-3 font-semibold text-center">Variasi Produk</th>
                        <th class="px-6 py-3 font-semibold text-right">Total Transaksi</th>
                        <th class="px-6 py-3 font-semibold text-center">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 font-mono text-xs font-bold text-indigo-600">
                                <a href="{{ route('sales.show', $sale->id) }}" class="hover:underline">
                                    {{ $sale->sale_number }}
                                </a>
                            </td>
                            <td class="px-6 py-3.5 font-medium text-slate-900">{{ $sale->user->name ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $sale->sold_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3.5 text-center text-xs text-slate-600">{{ $sale->items->count() }} produk</td>
                            <td class="px-6 py-3.5 text-right font-mono font-bold text-slate-900">
                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if($sale->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                        <i class="fa-solid fa-ban text-[10px] mr-1"></i> Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('sales.show', $sale->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-700 rounded-lg text-xs font-semibold transition">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500 text-sm">
                                Belum ada transaksi penjualan tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $sales->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
