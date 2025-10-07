<?php

namespace Database\Factories;

use App\Models\Affiliate;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AffiliateEarnings>
 */
class AffiliateEarningsFactory extends Factory
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
            'affiliate_id' => Affiliate::factory(),
            'transaction_id' => Transaction::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
