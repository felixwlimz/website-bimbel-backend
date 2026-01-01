<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'id' => Str::uuid(),
                'name' => "User {$i}",
                'email' => "user{$i}@test.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}
