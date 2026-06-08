<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('admin.produk.show', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'harga_produk'  => 'required|numeric|min:0',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
        ]);

        Produk::create($request->only('nama_produk', 'harga_produk', 'id_kategori'));

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk   = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'id_kategori'  => 'required|exists:kategori,id_kategori',
        ]);

        $produk->update($request->only('nama_produk', 'harga_produk', 'id_kategori'));

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
