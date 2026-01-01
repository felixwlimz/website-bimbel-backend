<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $package = Package::first();

        for ($i = 1; $i <= 5; $i++) {
            Question::create([
                'id' => Str::uuid(),
                'package_id' => $package->id,
                'title' => "Soal {$i}",
                'content' => "Ini adalah isi soal nomor {$i}",
                'media_type' => 'none',
                'weight' => 10,
                'explanation' => 'Ini pembahasan soal.',
            ]);
        }
    }
}
