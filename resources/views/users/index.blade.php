@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna & Hak Akses (Role)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Search bar -->
        <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2 max-w-md w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email pengguna..."
                       class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
            </div>
            <select name="role" class="py-2 px-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                <option value="">Semua Role</option>
                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ $role === 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
            <button type="submit" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition">
                Cari
            </button>
        </form>

        <a href="{{ route('users.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-sm self-start sm:self-auto">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama Pengguna</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold text-center">Hak Akses (Role)</th>
                        <th class="px-6 py-3 font-semibold">Tanggal Terdaftar</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 font-bold text-slate-800 flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <span>{{ $u->name }}</span>
                                @if($u->id === Auth::id())
                                    <span class="text-[10px] text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded font-normal border border-indigo-100">(Anda)</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-slate-600 text-xs">{{ $u->email }}</td>
                            <td class="px-6 py-3.5 text-center">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        <i class="fa-solid fa-shield-halved text-[10px] mr-1"></i> Admin / Owner
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-user-tag text-[10px] mr-1"></i> Staff Kasir
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-slate-500 text-xs">{{ $u->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('users.edit', $u->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-blue-50" title="Edit Pengguna">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>
                                @if($u->id !== Auth::id())
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-rose-50" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 text-sm">
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
