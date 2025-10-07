<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Affiliate>
 */
class AffiliateFactory extends Factory
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
            'code' => $this->faker->unique()->regexify('[A-Z]{5}'),
            'commission_rate' => $this->faker->randomFloat(2, 1, 1000),
            'is_approved' => $this->faker->boolean(70)
        ];
    }
}
