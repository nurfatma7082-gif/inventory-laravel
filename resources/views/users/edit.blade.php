@extends('layouts.app')

@section('title', 'Ubah Pengguna - ' . $user->name)
@section('page-title', 'Ubah Data & Role Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Edit Pengguna</h4>
                <p class="text-xs text-slate-500">Perbarui profil atau ubah role untuk {{ $user->name }}.</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>

            <div>
                <label for="role" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Peran / Hak Akses (Role) <span class="text-rose-500">*</span></label>
                <select id="role" name="role" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff (Hanya Transaksi & Lihat Produk)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin / Owner (Akses Penuh Master Data & Transaksi)</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Perbarui Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
