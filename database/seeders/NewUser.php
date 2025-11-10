<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Danru 1', 'username' => 'danru1', 'password' => 'danru123'],
            ['name' => 'Danru 2', 'username' => 'danru2', 'password' => 'danru123'],
            ['name' => 'Danru 3', 'username' => 'danru3', 'password' => 'danru123'],
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
