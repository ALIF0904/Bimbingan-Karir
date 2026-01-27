<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeTiket;

class TypeTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'VIP',
            'VVIP',
            'Regular',
            'Presale',
            'Early Bird',
        ];

        foreach ($data as $tipe) {
            TypeTiket::firstOrCreate([
                'tipe_tiket' => $tipe
            ]);
        }
    }
}
