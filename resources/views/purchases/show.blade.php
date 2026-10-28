@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $purchase->purchase_number)
@section('page-title', 'Detail Transaksi Pembelian (PO)')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('purchases.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat Pembelian</span>
        </a>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Nota</span>
            </button>
            @if(Auth::user()->isAdmin() && $purchase->status === 'completed')
                <form action="{{ route('purchases.cancel', $purchase->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi pengadaan ini? Stok barang yang sebelumnya bertambah akan ditarik kembali secara otomatis.');">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition flex items-center space-x-1.5 shadow-sm">
                        <i class="fa-solid fa-ban"></i>
                        <span>Batalkan Transaksi</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Invoice Header Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden p-6 md:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between pb-6 border-b border-slate-200 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Purchase Order (Stock-In)</span>
                <h3 class="text-2xl font-mono font-bold text-slate-900 mt-1">{{ $purchase->purchase_number }}</h3>
                <p class="text-xs text-slate-500 mt-1">Dicatat oleh: <strong class="text-slate-700">{{ $purchase->user->name ?? 'User' }}</strong> pada {{ $purchase->purchased_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="sm:text-right">
                <div class="mb-2">
                    @if($purchase->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-xs mr-1.5"></i> Transaksi Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                            <i class="fa-solid fa-ban text-xs mr-1.5"></i> Dibatalkan (Stok Ditarik)
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400">ID Referensi: #PO-{{ $purchase->id }}</p>
            </div>
        </div>

        <!-- Supplier & Transaction Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Informasi Pemasok (Supplier)</p>
                <h5 class="font-bold text-slate-800 text-base mt-1">{{ $purchase->supplier->name ?? 'Supplier Tidak Diketahui' }}</h5>
                <p class="text-xs text-slate-600 mt-0.5"><i class="fa-solid fa-phone text-[10px] text-slate-400 mr-1"></i> {{ $purchase->supplier->phone ?? '-' }}</p>
                <p class="text-xs text-slate-600 mt-0.5"><i class="fa-solid fa-envelope text-[10px] text-slate-400 mr-1"></i> {{ $purchase->supplier->email ?? '-' }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $purchase->supplier->address ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Catatan Transaksi</p>
                <p class="text-sm text-slate-700 italic mt-1">{{ $purchase->notes ?? 'Tidak ada catatan tambahan.' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-y border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">No.</th>
                        <th class="py-3 px-4 font-semibold">SKU & Nama Produk</th>
                        <th class="py-3 px-4 font-semibold text-center">Kuantitas</th>
                        <th class="py-3 px-4 font-semibold text-right">Harga Beli Satuan</th>
                        <th class="py-3 px-4 font-semibold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($purchase->items as $index => $item)
                        <tr>
                            <td class="py-3 px-4 text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-xs font-bold text-slate-600 block">{{ $item->product->sku ?? '-' }}</span>
                                <span class="font-medium text-slate-900">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-slate-800">{{ $item->quantity }}</td>
                            <td class="py-3 px-4 text-right font-mono text-xs text-slate-600">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-slate-300">
                        <td colspan="4" class="py-4 px-4 text-right font-bold text-slate-700 text-base">Total Nilai Pembelian:</td>
                        <td class="py-4 px-4 text-right font-mono text-xl font-extrabold text-indigo-600">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection
