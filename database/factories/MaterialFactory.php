<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\MaterialCopy;
use App\Models\MaterialType;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $material_type = MaterialType::inRandomOrder()->first();
        $publisher = Publisher::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        return [
            'title' => fake()->sentence(3),
            'type_id' => $material_type->type_id,
            'isbn' => fake()->isbn13(),
            'issn' => fake()->isbn13(),
            'publisher_id' => $publisher->publisher_id,
            'publication_year' => fake()->year('now'),
            'edition' => fake()->randomElement([
                fake()->randomDigitNotNull() . 'th Edition',
                fake()->year('now') . ' Edition',
                fake()->randomElement(['Standard', 'Deluxe', 'Collector’s', 'Limited', 'Revised']) . ' Edition',
                'Version ' . fake()->randomFloat(1, 1, 10)
            ]),
            'volume' => fake()->numberBetween(1, 10),
            'pages' => fake()->numberBetween(100, 1000),
            'size' => 20 . ' cm',
            'includes' => 'ill., maps.',
            'references' => fake()->sentence(7),
            'bibliography' => fake()->sentence(7),
            'description' => fake()->sentence(10),
            'category_id' => $category->category_id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Material $material){
            MaterialCopy::factory()->create(['material_id' => $material->material_id]);
        });
    }
}
