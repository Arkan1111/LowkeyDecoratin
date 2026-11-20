<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Customer
        User::create([
            'name' => 'Rizky', 
            'email' => 'customer@lowkey.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 2. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@lowkey.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. Akun Keuangan
        User::create([
            'name' => 'Staff Keuangan',
            'email' => 'keuangan@lowkey.test',
            'password' => Hash::make('password'),
            'role' => 'keuangan',
        ]);
    }
}