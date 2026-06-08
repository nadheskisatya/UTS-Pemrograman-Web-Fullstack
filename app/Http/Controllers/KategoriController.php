<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function show($id)
    {
        $kategori = Kategori::with('produk')->findOrFail($id);
        return view('admin.kategori.show', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate(['jenis_biji' => 'required|string|max:100']);
        Kategori::create($request->only('jenis_biji'));

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate(['jenis_biji' => 'required|string|max:100']);
        $kategori->update($request->only('jenis_biji'));

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        // Cek apakah masih ada produk
        if ($kategori->produk()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Kategori masih memiliki produk, tidak bisa dihapus.');
        }
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
