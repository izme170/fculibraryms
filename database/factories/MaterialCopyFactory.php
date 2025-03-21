<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\Material;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialCopy>
 */
class MaterialCopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $material = Material::inRandomOrder()->first();
        $vendor = Vendor::inRandomOrder()->first();
        $condition = Condition::inRandomOrder()->first();
        return [
            'material_id' => $material->material_id,
            'copy_number' => 'C' . fake()->unique()->randomNumber(3),
            'rfid' => fake()->randomNumber(9),
            'accession_number' => 'C-' . fake()->randomNumber(5),
            'call_number' => 'BOK 000 A1 2025',
            'price' => fake()->randomFloat(2, 100, 1000),
            'vendor_id' => $vendor->vendor_id,
            'fund_id' => 1,
            'date_acquired' => fake()->date(),
            'notes' => fake()->sentence(10),
            'condition_id' => $condition->condition_id,
            'is_available' => true,
            'is_archived' => false
        ];
    }
}
