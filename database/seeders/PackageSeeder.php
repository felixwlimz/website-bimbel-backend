<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        Package::create([
            'id' => Str::uuid(),
            'title' => 'Paket Tryout CPNS',
            'description' => 'Tryout CPNS lengkap dengan pembahasan',
            'type' => 'tryout',
            'price' => 150000,
            'duration_minutes' => 90,
            'passing_grade' => 70,
            'status' => 'published',
            'created_by' => $admin->id,
        ]);
    }
}
