<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('kasir.index', compact('produk'));
    }

    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|exists:produk,id_produk',
            'items.*.qty'    => 'required|integer|min:1',
            'uang_pelanggan' => 'required|numeric|min:0',
            // total_harga tidak divalidasi dari request, kita hitung ulang di backend!
        ]);

        $totalHarga = 0;
        $itemsData = [];

        // Hitung total harga dengan mengambil harga valid dari Database
        foreach ($request->items as $item) {
            $produk = Produk::find($item['id']);
            $subTotal = $produk->harga_produk * $item['qty'];
            $totalHarga += $subTotal;

            // Simpan sementara di array agar tidak mengulang query find()
            $itemsData[] = [
                'id_produk'    => $item['id'],
                'quantity'     => $item['qty'],
                'harga_satuan' => $produk->harga_produk,
                'total_harga'  => $subTotal,
            ];
        }

        // Cek jika uang kurang (Pencegahan bypass JS)
        if ($request->uang_pelanggan < $totalHarga) {
            return response()->json([
                'success' => false,
                'message' => 'Uang pelanggan tidak mencukupi.'
            ], 400);
        }

        $transaksi = Transaksi::create([
            'uang_pelanggan' => $request->uang_pelanggan,
            'total_harga'    => $totalHarga,
            'kembalian'      => $request->uang_pelanggan - $totalHarga,
        ]);

        foreach ($itemsData as $data) {
            $data['id_transaksi'] = $transaksi->id_transaksi;
            DetailTransaksi::create($data);
        }

        return response()->json([
            'success'   => true,
            'transaksi' => $transaksi->load('detailTransaksi.produk'),
        ]);
    }
}
