@extends('layouts.app')

@section('title', 'Daftar Pemasok')
@section('page-title', 'Kelola Pemasok (Suppliers)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Search bar -->
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex items-center gap-2 max-w-md w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, atau telepon..."
                       class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
            </div>
            <button type="submit" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition">
                Cari
            </button>
        </form>

        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-sm self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Pemasok</span>
        </a>
    </div>

    <!-- Suppliers Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama Pemasok</th>
                        <th class="px-6 py-3 font-semibold">No. Telepon / HP</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Alamat</th>
                        <th class="px-6 py-3 font-semibold text-center">Riwayat PO</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $sup)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 font-bold text-slate-800">{{ $sup->name }}</td>
                            <td class="px-6 py-3.5 text-slate-600 text-xs font-mono">{{ $sup->phone ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $sup->email ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-slate-500 text-xs truncate max-w-xs">{{ $sup->address ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $sup->purchases_count }} pengadaan
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('suppliers.edit', $sup->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-blue-50" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $sup->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasok {{ $sup->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-rose-50" title="Hapus">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-500 text-sm">
                                Belum ada data pemasok yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
