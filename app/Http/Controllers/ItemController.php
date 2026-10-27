<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // <-- Jangan lupa tambahkan baris ini di atas

class ItemController extends Controller
{
    /**
     * Menampilkan daftar semua barang (Read).
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form untuk menambah barang baru (Create form).
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Menyimpan data barang baru ke database (Store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail barang tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    /**
     * Memperbarui data barang di database (Update).
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Menghapus barang dari database (Delete).
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus!');
    }
}