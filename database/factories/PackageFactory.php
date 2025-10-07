<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Question;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->word(),
            'type' => $this->faker->randomElement(['materi', 'soal', 'bundling']),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10000, 100000),
            'duration_minutes' => $this->faker->numberBetween(30, 120),
            'thumbnail' => $this->faker->imageUrl(),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
