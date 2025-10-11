<?php

namespace Database\Seeders;

use App\Models\PointQr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointQrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $points = [
            'Pintu Utama',
            'Gudang Farmasi',
            'Ruang Perawat',
            'Laboratorium',
            'Kantor Administrasi',
            'Ruang Rapat',
            'Parkiran Depan',
        ];

        foreach ($points as $nama) {
            PointQr::create([
                'nama_point' => $nama,
            ]);
        }
    }
}
