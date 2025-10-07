<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Voucher::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'code' => 'VCHR-' . strtoupper($this->faker->unique()->bothify('??###??')),
            'discount_rp' => $this->faker->numberBetween(1000, 100000),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'active' => $this->faker->boolean(),
            'created_by' => User::factory()

        ];
    }
}
