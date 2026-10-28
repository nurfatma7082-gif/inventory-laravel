@extends('layouts.app')

@section('title', 'Struk Penjualan ' . $sale->sale_number)
@section('page-title', 'Detail Transaksi Penjualan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat Penjualan</span>
        </a>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Struk Kasir</span>
            </button>
            @if(Auth::user()->isAdmin() && $sale->status === 'completed')
                <form action="{{ route('sales.cancel', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi penjualan ini? Stok barang yang terjual akan otomatis dikembalikan ke inventaris.');">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition flex items-center space-x-1.5 shadow-sm">
                        <i class="fa-solid fa-ban"></i>
                        <span>Batalkan Penjualan</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Receipt / Invoice Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-6 md:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between pb-6 border-b border-slate-200 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Struk Resmi Kasir (Sales Receipt)</span>
                <h3 class="text-2xl font-mono font-bold text-slate-900 mt-1">{{ $sale->sale_number }}</h3>
                <p class="text-xs text-slate-500 mt-1">Dilayani oleh: <strong class="text-slate-700">{{ $sale->user->name ?? 'Kasir' }}</strong> pada {{ $sale->sold_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="sm:text-right">
                <div class="mb-2">
                    @if($sale->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-xs mr-1.5"></i> Transaksi Berhasil
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                            <i class="fa-solid fa-ban text-xs mr-1.5"></i> Dibatalkan (Stok Dipulihkan)
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400">ID Faktur: #INV-{{ $sale->id }}</p>
            </div>
        </div>

        @if($sale->notes)
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs">
                <span class="font-semibold text-slate-500 uppercase block mb-1">Catatan / Pelanggan:</span>
                <p class="text-slate-700">{{ $sale->notes }}</p>
            </div>
        @endif

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-y border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">No.</th>
                        <th class="py-3 px-4 font-semibold">SKU & Nama Produk</th>
                        <th class="py-3 px-4 font-semibold text-right">Harga Satuan</th>
                        <th class="py-3 px-4 font-semibold text-center">Qty</th>
                        <th class="py-3 px-4 font-semibold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sale->items as $index => $item)
                        <tr>
                            <td class="py-3 px-4 text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-xs font-bold text-slate-600 block">{{ $item->product->sku ?? '-' }}</span>
                                <span class="font-medium text-slate-900">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                            </td>
                            <td class="py-3 px-4 text-right font-mono text-xs text-slate-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-slate-800">{{ $item->quantity }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-slate-300">
                        <td colspan="4" class="py-4 px-4 text-right font-bold text-slate-700 text-base">Total Akhir Transaksi:</td>
                        <td class="py-4 px-4 text-right font-mono text-xl font-extrabold text-emerald-600">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
