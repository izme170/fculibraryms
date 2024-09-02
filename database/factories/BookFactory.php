<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 4),
            'qty' => fake()->numberBetween(1, 10),
            'available' => fake()->numberBetween(1, 10),
            'is_archived' => false
        ];
    }
}
