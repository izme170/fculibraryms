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
            'book_number' => fake()->isbn10(),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 4),
            'qty' => 10,
            'available' => 10,
            'is_archived' => false
        ];
    }
}
