<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Package;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'package_id' => Package::factory(),
            'voucher_id' => Voucher::factory(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
            'invoice_number' => $this->faker->unique()->numerify('INV-#####'),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
        ];
    }
}