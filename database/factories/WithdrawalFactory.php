<?php

namespace Database\Factories;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdrawal>
 */
class WithdrawalFactory extends Factory
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
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'rejected']),
            'bank_name' => $this->faker->company(),
            'account_number' => $this->faker->bankAccountNumber(),
            'account_name' => $this->faker->name(),
            'approved_by' => User::factory()
        ];
    }
}
