<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'role_id' => 2,
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => fake()->randomDigit(),
            'username' => fake()->unique()->userName(),
            'password' => bcrypt('user'),
            'is_archived' => false
        ];
    }
}
