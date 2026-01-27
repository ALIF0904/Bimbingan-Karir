<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'nama'       => 'BCA',
                'tipe'       => 'bank',
                'nomor'      => '1234567890',
                'atas_nama'  => 'PT Event Nusantara',
                'is_active'  => true,
            ],
            [
                'nama'       => 'BRI',
                'tipe'       => 'bank',
                'nomor'      => '0987654321',
                'atas_nama'  => 'PT Event Nusantara',
                'is_active'  => true,
            ],
            [
                'nama'       => 'DANA',
                'tipe'       => 'ewallet',
                'nomor'      => '081234567890',
                'atas_nama'  => 'Event Organizer',
                'is_active'  => true,
            ],
            [
                'nama'       => 'OVO',
                'tipe'       => 'ewallet',
                'nomor'      => '081298765432',
                'atas_nama'  => 'Event Organizer',
                'is_active'  => true,
            ],
            [
                'nama'       => 'QRIS',
                'tipe'       => 'qris',
                'nomor'      => null,
                'atas_nama'  => 'Event Organizer',
                'is_active'  => true,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::updateOrCreate(
                [
                    'nama' => $payment['nama'],
                    'tipe' => $payment['tipe'],
                ],
                $payment
            );
        }
    }
}
