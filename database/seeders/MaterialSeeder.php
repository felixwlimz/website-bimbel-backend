<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $package = Package::first();

        Material::insert([
            [
                'id' => Str::uuid(),
                'package_id' => $package->id,
                'title' => 'Pendahuluan CPNS',
                'drive_link' => 'https://drive.google.com/example1',
                'access_type' => 'preview',
                'order' => 1,
            ],
            [
                'id' => Str::uuid(),
                'package_id' => $package->id,
                'title' => 'Materi Inti CPNS',
                'drive_link' => 'https://drive.google.com/example2',
                'access_type' => 'full',
                'order' => 2,
            ],
        ]);
    }
}
