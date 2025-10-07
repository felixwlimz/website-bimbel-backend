<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\map;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
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
            'question_id' => Question::factory(),
            'option_key' => $this->faker->word(),
            'content' => $this->faker->sentence(),
        ];
    }
}
