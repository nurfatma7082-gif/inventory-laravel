@extends('layouts.app')

@section('title', 'Tambah Pemasok')
@section('page-title', 'Tambah Pemasok (Supplier) Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Formulir Pemasok</h4>
                <p class="text-xs text-slate-500">Daftarkan supplier baru untuk transaksi pembelian stok.</p>
            </div>
            <a href="{{ route('suppliers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('suppliers.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Pemasok / Badan Usaha <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                       placeholder="Contoh: PT Sumber Elektronik Abadi">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono"
                           placeholder="Contoh: 081234567890">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                           placeholder="Contoh: contact@supplier.com">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                          placeholder="Jalan, nomor, kota, provinsi...">{{ old('address') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Pemasok</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
