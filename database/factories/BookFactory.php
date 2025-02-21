<?php

namespace Database\Factories;

use App\Models\Category;
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
        $category = Category::inRandomOrder()->first();
        return [
            'book_rfid' => fake()->randomNumber(9),
            'accession_number' => 'C-' . fake()->randomNumber(5),
            'call_number' => 'BOK 000 A1 2025',
            'title' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'description' => fake()->sentence(10),
            'category_id' => $category->category_id,
        ];
    }
}
