<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\MaterialCopy;
use App\Models\Patron;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowedMaterial>
 */
class BorrowedMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $copy = MaterialCopy::inRandomOrder()->first();
        $patron = Patron::inRandomOrder()->first();
        $user = User::where('role_id', 1)->inRandomOrder()->first();
        $created_at = fake()->dateTime();
        $due = (clone $created_at)->modify('+'. 60 . 'minutes');
        $returned = (clone $due)->modify('-'. rand(20, 50) . 'minutes');
        $condition = Condition::inRandomOrder()->first();
        return [
            'copy_id' => $copy->copy_id,
            'patron_id' => $patron->patron_id,
            'user_id' => $user->user_id,
            'due_date' => $due,
            'fine' => 0,
            'returned' => $returned,
            'condition_before' => $condition->condition_id,
            'condition_after' => $condition->condition_id,
            'created_at' => $created_at
        ];
    }
}
