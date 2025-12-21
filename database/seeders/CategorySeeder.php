<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Konser',
            'Seminar',
            'Workshop',
        ];

        foreach ($kategoris as $nama) {
            Kategori::updateOrCreate(
                ['nama' => $nama],   // kondisi pencarian
                ['nama' => $nama]    // data yang disimpan
            );
        }
    }
}
