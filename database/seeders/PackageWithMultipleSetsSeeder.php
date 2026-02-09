<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\SubTopic;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageWithMultipleSetsSeeder extends Seeder
{
    /**
     * Contoh: Create 1 Package dengan 3 Question Sets
     * Package: "Ujian Matematika"
     * - Set 1: Aljabar (5 soal)
     * - Set 2: Geometri (5 soal)
     * - Set 3: Statistik (5 soal)
     */
    public function run(): void
    {
        // Create package
        $package = Package::create([
            'id' => Str::uuid(),
            'title' => 'Ujian Matematika Lengkap',
            'description' => 'Ujian komprehensif mencakup Aljabar, Geometri, dan Statistik',
            'type' => 'test',
            'price' => 50000,
            'duration_minutes' => 120,
            'passing_grade' => 70,
            'status' => 'published',
            'created_by' => '1',
        ]);

        // Create question sets (sub-topics)
        $sets = [
            [
                'name' => 'Aljabar',
                'questions' => [
                    [
                        'title' => 'Persamaan Linear Sederhana',
                        'content' => 'Selesaikan: 2x + 5 = 13',
                        'explanation' => 'x = 4',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => 'x = 2', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => 'x = 4', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => 'x = 6', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => 'x = 8', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Sistem Persamaan Linear',
                        'content' => 'Jika x + y = 10 dan x - y = 2, maka x = ?',
                        'explanation' => 'x = 6, y = 4',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => 'x = 4', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => 'x = 5', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => 'x = 6', 'is_correct' => true, 'score' => 1],
                            ['key' => 'D', 'content' => 'x = 7', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Faktorisasi Kuadrat',
                        'content' => 'Faktorkan: x² + 5x + 6',
                        'explanation' => '(x + 2)(x + 3)',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '(x + 1)(x + 6)', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '(x + 2)(x + 3)', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '(x + 2)(x + 4)', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '(x + 3)(x + 3)', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Eksponen',
                        'content' => 'Hitung: 2³ × 2² = ?',
                        'explanation' => '2⁵ = 32',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '16', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '32', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '64', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '128', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Logaritma',
                        'content' => 'Jika log₁₀(x) = 2, maka x = ?',
                        'explanation' => 'x = 100',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '10', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '20', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '100', 'is_correct' => true, 'score' => 1],
                            ['key' => 'D', 'content' => '1000', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Geometri',
                'questions' => [
                    [
                        'title' => 'Luas Segitiga',
                        'content' => 'Luas segitiga dengan alas 10 cm dan tinggi 8 cm adalah?',
                        'explanation' => 'Luas = ½ × alas × tinggi = ½ × 10 × 8 = 40 cm²',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '40 cm²', 'is_correct' => true, 'score' => 1],
                            ['key' => 'B', 'content' => '80 cm²', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '20 cm²', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '160 cm²', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Keliling Lingkaran',
                        'content' => 'Keliling lingkaran dengan jari-jari 7 cm adalah? (π = 22/7)',
                        'explanation' => 'K = 2πr = 2 × 22/7 × 7 = 44 cm',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '22 cm', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '44 cm', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '88 cm', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '154 cm', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Volume Kubus',
                        'content' => 'Volume kubus dengan sisi 5 cm adalah?',
                        'explanation' => 'V = s³ = 5³ = 125 cm³',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '25 cm³', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '75 cm³', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '125 cm³', 'is_correct' => true, 'score' => 1],
                            ['key' => 'D', 'content' => '250 cm³', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Teorema Pythagoras',
                        'content' => 'Segitiga siku-siku dengan sisi 3 dan 4, sisi miring adalah?',
                        'explanation' => 'c² = 3² + 4² = 9 + 16 = 25, c = 5',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '5', 'is_correct' => true, 'score' => 1],
                            ['key' => 'B', 'content' => '6', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '7', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '8', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Sudut Segitiga',
                        'content' => 'Jumlah sudut dalam segitiga adalah?',
                        'explanation' => 'Jumlah sudut dalam segitiga = 180°',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '90°', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '180°', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '270°', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '360°', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Statistik',
                'questions' => [
                    [
                        'title' => 'Mean (Rata-rata)',
                        'content' => 'Mean dari data: 2, 4, 6, 8, 10 adalah?',
                        'explanation' => 'Mean = (2+4+6+8+10)/5 = 30/5 = 6',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '4', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '6', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '8', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '10', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Median',
                        'content' => 'Median dari data: 1, 3, 5, 7, 9 adalah?',
                        'explanation' => 'Median adalah nilai tengah = 5',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '3', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '5', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => '7', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '9', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Modus',
                        'content' => 'Modus dari data: 2, 2, 3, 4, 4, 4, 5 adalah?',
                        'explanation' => 'Modus adalah nilai yang paling sering muncul = 4',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '2', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => '3', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '4', 'is_correct' => true, 'score' => 1],
                            ['key' => 'D', 'content' => '5', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Peluang',
                        'content' => 'Peluang mendapat angka 6 pada dadu adalah?',
                        'explanation' => 'P(6) = 1/6',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => '1/6', 'is_correct' => true, 'score' => 1],
                            ['key' => 'B', 'content' => '1/5', 'is_correct' => false, 'score' => 0],
                            ['key' => 'C', 'content' => '1/4', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => '1/3', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                    [
                        'title' => 'Standar Deviasi',
                        'content' => 'Standar deviasi mengukur?',
                        'explanation' => 'Standar deviasi mengukur penyebaran data dari rata-rata',
                        'weight' => 1,
                        'options' => [
                            ['key' => 'A', 'content' => 'Nilai tengah', 'is_correct' => false, 'score' => 0],
                            ['key' => 'B', 'content' => 'Penyebaran data', 'is_correct' => true, 'score' => 1],
                            ['key' => 'C', 'content' => 'Nilai maksimal', 'is_correct' => false, 'score' => 0],
                            ['key' => 'D', 'content' => 'Nilai minimal', 'is_correct' => false, 'score' => 0],
                        ]
                    ],
                ]
            ],
        ];

        // Create sub-topics and questions
        foreach ($sets as $setData) {
            $subTopic = SubTopic::create([
                'id' => Str::uuid(),
                'package_id' => $package->id,
                'name' => $setData['name'],
            ]);

            foreach ($setData['questions'] as $index => $questionData) {
                $question = Question::create([
                    'id' => Str::uuid(),
                    'package_id' => $package->id,
                    'sub_topic_id' => $subTopic->id,
                    'title' => $questionData['title'],
                    'content' => $questionData['content'],
                    'media_type' => 'text',
                    'weight' => $questionData['weight'],
                    'explanation' => $questionData['explanation'],
                    'order' => $index,
                ]);

                foreach ($questionData['options'] as $optionIndex => $optionData) {
                    Option::create([
                        'id' => Str::uuid(),
                        'question_id' => $question->id,
                        'key' => $optionData['key'],
                        'content' => $optionData['content'],
                        'is_correct' => $optionData['is_correct'],
                        'score' => $optionData['score'],
                        'order' => $optionIndex,
                    ]);
                }
            }
        }

        echo "✓ Package 'Ujian Matematika Lengkap' created with 3 question sets (15 total questions)\n";
    }
}
