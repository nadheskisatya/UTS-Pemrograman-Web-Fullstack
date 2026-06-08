<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')
                              ->latest()
                              ->get();
        return view('admin.orders.index', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->detailTransaksi()->delete();
        $transaksi->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }
}
