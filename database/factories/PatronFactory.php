<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patron>
 */
class PatronFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::inRandomOrder()->first();
        $courses = Course::where('department_id', '=', $department->department_id)->inRandomOrder()->first();
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => fake()->phoneNumber(),
            'type_id' => fake()->numberBetween(1, 3),
            'address' => fake()->address(),
            'school_id' => fake()->unique()->randomNumber(8),
            'department_id' => $department->department_id,
            'course_id' => $courses->course_id ?? null,
            'year' => fake()->numberBetween(1, 4),
            'adviser_id' => fake()->numberBetween(1, 3),
            'library_id' => fake()->md5(),
            'is_archived' => false
        ];
    }
}
