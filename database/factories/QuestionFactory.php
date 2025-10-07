<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = Question::class;

    public function definition(): array
    {
        return [
            //
            'id' => $this->faker->uuid(),
            'judulSoal' => $this->faker->sentence(),
            'jenisSoal' => $this->faker->randomElement(['teks', 'gambar', 'audio']),
            'package_id' => Package::factory(),
            'isiSoal' => $this->faker->text(),
            'mediaSoal' => $this->faker->url(),
            'bobot' => $this->faker->numberBetween(1, 10),
            'jawabanBenar' => $this->faker->numberBetween(1, 4),
            'pembahasan' => $this->faker->text(),
            'subMateri' => $this->faker->word(),

        ];
    }
}
