<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Role;
use App\Models\User;
use App\Models\PatronType;
use App\Models\Patron;
use App\Models\Category;
use App\Models\Book;
use App\Models\Course;
use App\Models\Department;
use App\Models\Marketer;
use App\Models\Purpose;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        Role::create([
            'role' => 'Admin'
        ]);

        Role::create([
            'role' => 'Librarian'
        ]);

        // Seed Users
        User::factory(20)->create();

        // Seed Patron Types
        PatronType::create(['type' => 'Student']);
        PatronType::create(['type' => 'Faculty']);
        PatronType::create(['type' => 'Guest']);

        // Seed Department
        Department::create(['department' => 'CCS']);
        Department::create(['department' => 'CN']);
        Department::create(['department' => 'CCJE']);

        // Seed Course
        Course::create(['course' => 'BSIT']);
        Course::create(['course' => 'BSN']);
        Course::create(['course' => 'BSC']);

        // Seed Adviser
        Adviser::factory(3)->create();

        // Seed Patrons
        Patron::factory(20)->create();

        // Seed Categories
        Category::create(['category' => 'Fiction']);
        Category::create(['category' => 'Non-Fiction']);
        Category::create(['category' => 'Science']);
        Category::create(['category' => 'Mathematics']);

        // Seed Purposes
        Purpose::create(['purpose' => 'Read']);
        Purpose::create(['purpose' => 'Borrow Books']);
        Purpose::create(['purpose' => 'Research']);
        Purpose::create(['purpose' => 'WiFi/Internet']);

        // Seed Books
        Book::factory(20)->create();

        // Seed Marketer
        Marketer::factory(10)->create();

        // Seed Admin
        User::create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'role_id' => 1,
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => fake()->randomDigit(),
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'is_archived' => false
        ]);
    }
}
