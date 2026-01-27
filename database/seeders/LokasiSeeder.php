<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = [
            ['nama_lokasi' => 'Stadion Utama'],
            ['nama_lokasi' => 'Galeri Seni Kota'],
            ['nama_lokasi' => 'Taman Kota'],
            ['nama_lokasi' => 'Gedung Serbaguna'],
            ['nama_lokasi' => 'Aula Kampus'],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::firstOrCreate($lokasi);
        }
    }
};
