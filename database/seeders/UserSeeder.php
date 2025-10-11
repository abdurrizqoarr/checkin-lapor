<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password123'), // ganti sesuai kebutuhan
        ]);

        // Beberapa user tambahan (contoh)
        $users = [
            ['name' => 'Budi Santoso', 'username' => 'budi', 'password' => 'budi123'],
            ['name' => 'Siti Aminah', 'username' => 'siti', 'password' => 'siti123'],
            ['name' => 'Rizal Maulana', 'username' => 'rizal', 'password' => 'rizal123'],
        ];

        foreach ($users as $u) {
            User::create([
                'name' => $u['name'],
                'username' => $u['username'],
                'password' => Hash::make($u['password']),
            ]);
        }
    }
}
