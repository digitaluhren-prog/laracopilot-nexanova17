<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@platform.al',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+355 69 999 9999',
            'city' => 'Tiranë',
        ]);

        // Create Test User
        User::create([
            'name' => 'User Test',
            'email' => 'user@platform.al',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '+355 69 888 8888',
            'city' => 'Tiranë',
        ]);

        // Create 15 regular users
        $names = [
            'Alban Krasniqi',
            'Arjan Hoxha',
            'Besnik Rama',
            'Dorina Berisha',
            'Elona Shala',
            'Fatmir Gashi',
            'Gentiana Morina',
            'Hasan Musliu',
            'Ilir Kelmendi',
            'Jonida Leka',
            'Korab Dervishi',
            'Luana Hasani',
            'Mentor Bytyqi',
            'Nora Halili',
            'Petrit Zajmi',
        ];

        $cities = ['Tiranë', 'Durrës', 'Vlorë', 'Shkodër', 'Korçë', 'Elbasan', 'Fier'];

        foreach ($names as $index => $name) {
            $firstName = explode(' ', $name)[0];
            User::create([
                'name' => $name,
                'email' => strtolower($firstName) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+355 69 ' . str_pad($index + 100, 3, '0', STR_PAD_LEFT) . ' ' . rand(1000, 9999),
                'city' => $cities[array_rand($cities)],
            ]);
        }

        $this->command->info('Users seeded: 1 admin + 1 test user + 15 regular users');
    }
}