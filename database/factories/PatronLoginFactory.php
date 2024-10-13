<?php

namespace Database\Factories;

use App\Models\Marketer;
use App\Models\Patron;
use App\Models\Purpose;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatronLogin>
 */
class PatronLoginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patron = Patron::inRandomOrder()->first();
        $purpose = Purpose::inRandomOrder()->first();
        $marketer = Marketer::inRandomOrder()->first();
        $loginAt = fake()->dateTimeBetween(now()->startOfMonth(), now());
        $logoutAt = (clone $loginAt)->modify('+' . rand(1, 240) . ' minutes');
        return [
            'patron_id' => $patron->patron_id,
            'purpose_id' => $purpose->purpose_id,
            'marketer_id' => $marketer->marketer_id,
            'login_at' => $loginAt,
            'logout_at' => $logoutAt
        ];
    }
}
