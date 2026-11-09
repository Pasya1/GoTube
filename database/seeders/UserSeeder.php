<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Kurir
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@example.com',
            'password' => Hash::make('kurir123'),
            'role' => 'kurir'
        ]);

        User::create([
            'name' => 'Supervisor',
            'email' => 'spv@example.com',
            'password' => Hash::make('spv123'),
            'role' => 'spv'
        ]);
    }
}
