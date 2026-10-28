@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('page-title', 'Tambah Pengguna & Tentukan Role')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Registrasi Pengguna Baru</h4>
                <p class="text-xs text-slate-500">Buat akun login dan tetapkan hak akses (Admin atau Staff).</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Contoh: Budi Santoso">
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Contoh: budi@inventory.com">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password <span class="text-rose-500">*</span></label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Minimal 6 karakter">
            </div>

            <div>
                <label for="role" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Peran / Hak Akses (Role) <span class="text-rose-500">*</span></label>
                <select id="role" name="role" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff (Hanya Transaksi & Lihat Produk)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin / Owner (Akses Penuh Master Data, Users, & Batalkan Transaksi)</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Daftarkan Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
