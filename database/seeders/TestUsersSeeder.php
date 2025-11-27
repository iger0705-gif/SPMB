<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test Pendaftar',
                'email' => 'pendaftar@test.com',
                'phone' => '081234567890',
                'role' => 'pendaftar',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'phone' => '081234567891',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Test Verifikator',
                'email' => 'verifikator@test.com',
                'phone' => '081234567892',
                'role' => 'verifikator_adm',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Test Keuangan',
                'email' => 'keuangan@test.com',
                'phone' => '081234567893',
                'role' => 'keuangan',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Test Kepsek',
                'email' => 'kepsek@test.com',
                'phone' => '081234567894',
                'role' => 'kepsek',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}