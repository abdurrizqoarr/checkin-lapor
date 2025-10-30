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
            'GERBANG UTAMA',
            'MCU',
            'GEDUNG UTAMA',
            'BERLIAN',
            'OK',
            'GIZI',
            'IGD',
            'RADIOLOGI',
            'RUBY',
            'SANITASI',
            'PICU',
            'SAFIR',
            'MUTIARA',
            'GUDANG FARMASI',
            'NILAM',
            'JENAZAH',
        ];

        foreach ($points as $nama) {
            PointQr::create([
                'nama_point' => $nama,
            ]);
        }
    }
}
