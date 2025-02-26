<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCopy>
 */
class BookCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book = Book::inRandomOrder()->first();
        $vendor = Vendor::inRandomOrder()->first();
        return [
            'book_id' => $book->book_id,
            'copy_number' => 'C' . fake()->unique()->randomNumber(3),
            'rfid' => fake()->randomNumber(9),
            'accession_number' => 'C-' . fake()->randomNumber(5),
            'call_number' => 'BOK 000 A1 2025',
            'price' => fake()->randomFloat(2, 100, 1000),
            'vendor_id' => 1,
            'fund_id' => 1,
            'date_acquired' => fake()->date(),
            'notes' => fake()->sentence(10),
            'is_available' => true,
            'is_archived' => false
        ];
    }
}
