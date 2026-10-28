@extends('layouts.app')

@section('title', 'Ubah Kategori - ' . $category->name)
@section('page-title', 'Ubah Kategori Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h4 class="font-bold text-slate-800 text-base">Edit Data Kategori</h4>
                <p class="text-xs text-slate-500">Perbarui informasi untuk kategori {{ $category->name }}.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Deskripsi / Catatan</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Perbarui Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
