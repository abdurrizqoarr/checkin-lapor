<?php

namespace Database\Seeders;

use App\Models\JadwalUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar hari yang mungkin
        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        ];

        // Ambil semua user yang sudah disediakan oleh UserSeeder
        $users = User::all();

        foreach ($users as $user) {
            // Tentukan jumlah hari kerja acak per user (contoh: 3–5 hari)
            $jumlahHari = rand(3, 5);
            $hariKerja = collect($hariList)->shuffle()->take($jumlahHari);

            foreach ($hariKerja as $hari) {
                JadwalUser::create([
                    'user_id' => $user->id,
                    'hari' => $hari,
                ]);
            }
        }
    }
}
