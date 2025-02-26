<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCopy;
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
            'title' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'publisher' => fake()->company(),
            'publication_date' => fake()->year('now'),
            'edition' => fake()->randomElement([
                fake()->randomDigitNotNull() . 'th Edition',
                fake()->year('now') . ' Edition',
                fake()->randomElement(['Standard', 'Deluxe', 'Collector’s', 'Limited', 'Revised']) . ' Edition',
                'Version ' . fake()->randomFloat(1, 1, 10)
            ]),
            'volume' => fake()->numberBetween(1, 10),
            'pages' => fake()->numberBetween(100, 1000),
            'references' => fake()->sentence(7),
            'bibliography' => fake()->sentence(7),
            'description' => fake()->sentence(10),
            'category_id' => $category->category_id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Book $book){
            BookCopy::factory()->create(['book_id' => $book->book_id]);
        });
    }
}
