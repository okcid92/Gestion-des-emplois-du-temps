<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@ibam.com'],
            [
                'name' => 'Admin',
                'prenom' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'administrator',
            ]
        );

    }
}
