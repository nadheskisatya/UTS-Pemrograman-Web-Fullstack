<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['jenis_biji' => 'Arabika'],
            ['jenis_biji' => 'Robusta'],
            ['jenis_biji' => 'Liberika'],
            ['jenis_biji' => 'Excelsa'],
            ['jenis_biji' => 'Blend'],
        ];

        foreach ($data as $item) {
            Kategori::create($item);
        }
    }
}
