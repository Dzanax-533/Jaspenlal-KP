<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Staf Keuangan
        User::create([
            'name'     => 'Staf Keuangan',
            'username' => 'keuangan',
            'email'    => 'keuangan@test.com',
            'password' => Hash::make('password'),
            'role'     => 'keuangan',
        ]);

        // Akun Klien
        User::create([
            'name'     => 'Muis Nuryana',
            'username' => 'Muis',
            'email'    => 'klien@test.com',
            'password' => Hash::make('password'),
            'role'     => 'klien',
        ]);

        // Akun Konsultan
        User::create([
            'name'     => 'Konsultan',
            'username' => 'konsultan',
            'email'    => 'konsultan@test.com',
            'password' => Hash::make('password'),
            'role'     => 'konsultan',
        ]);

        // Akun Admin
        User::create([
            'name'     => 'Admin Sistem',
            'username' => 'admin',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
    }
}
