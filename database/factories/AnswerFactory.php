<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnswerSheet;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
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
            'answer_sheet_id' => AnswerSheet::factory(),
            'question_id' => Question::factory(),
            'is_correct' => $this->faker->boolean(50), // Assuming a 50% chance of being correct
        ];
    }
}
