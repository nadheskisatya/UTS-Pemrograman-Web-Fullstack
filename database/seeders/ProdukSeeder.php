<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_produk' => 'Kopi Arabika Gayo',     'harga_produk' => 35000, 'id_kategori' => 1],
            ['nama_produk' => 'Kopi Robusta Lampung',   'harga_produk' => 25000, 'id_kategori' => 2],
            ['nama_produk' => 'Kopi Liberika Jambi',    'harga_produk' => 40000, 'id_kategori' => 3],
            ['nama_produk' => 'Kopi Excelsa Toraja',    'harga_produk' => 45000, 'id_kategori' => 4],
            ['nama_produk' => 'Kopi Blend Signature',   'harga_produk' => 30000, 'id_kategori' => 5],
        ];

        foreach ($data as $item) {
            Produk::create($item);
        }
    }
}
