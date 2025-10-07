<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Package;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnswerSheet>
 */
class AnswerSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'package_id' => Package::factory(),
            'total_score' => $this->faker->numberBetween(0, 100),
            'passing' => $this->faker->boolean(70), // 70% chance of passing
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
