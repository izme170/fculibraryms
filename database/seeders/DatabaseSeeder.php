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
use Database\Factories\BookFactory;
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
        Adviser::factory(30)->create();

        // Seed Patrons
        Patron::factory(20)->create();

        // Seed Categories
        $categories = [
            'Filipiniana',
            'Asiana',
            'Rizaliana',
            'Thesis',
            'Biographies & Autobiographies',
            'Memoirs',
            'Self-Help',
            'Health & Wellness',
            'Cookbooks',
            'Travel',
            'True Crime',
            'History',
            'Politics',
            'Business & Economics',
            'Science',
            'Philosophy',
            'Religion & Spirituality',
            'Psychology',
            'Parenting & Relationships',
            'Nature',
            'Education & Teaching',
            'Reference',
            'Graphic Novels',
            'Poetry',
            'Plays & Drama',
            'Literary Criticism',
            'Anthologies & Collections',
            'Humor',
            'Arts & Photography',
            'Technology & Computers',
            'Sports & Outdoors',
            'Gardening',
            'Crafts & Hobbies',
            'African Literature',
            'Asian Literature',
            'Latin American Literature',
            'European Literature',
            'Indigenous Literature',
            'Literary Fiction',
            'Historical Fiction',
            'Science Fiction',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Horror',
            'Romance',
            'Adventure',
            'Dystopian',
            'Young Adult',
            'Children’s Fiction',
            'Classic Fiction',
        ];

        foreach ($categories as $category) {
            Category::create(['category' => $category]);
        }
        // Category::create(['category' => 'Fiction']);
        // Category::create(['category' => 'Non-Fiction']);
        // Category::create(['category' => 'Science']);
        // Category::create(['category' => 'Mathematics']);

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

        // Seed Patron
        Patron::create([
            'first_name' => 'Jerico',
            'middle_name' => 'De La Cruz',
            'last_name' => 'Lopez',
            'email' => 'jerico@gmail.com',
            'contact_number' => '09123456789',
            'type_id' => 1,
            'address' => 'Capiz',
            'school_id' => '21-C0000',
            'department_id' => 1,
            'course_id' => 1,
            'year' => 4,
            'adviser_id' => 1,
            'library_id' => '2598373405',
            'is_archived' => false
        ]);

        Patron::create([
            'first_name' => 'Erlou Fall',
            'middle_name' => '',
            'last_name' => 'Lacorte',
            'email' => 'fall@gmail.com',
            'contact_number' => '09123456789',
            'type_id' => 1,
            'address' => 'Capiz',
            'school_id' => '21-C0000',
            'department_id' => 1,
            'course_id' => 1,
            'year' => 4,
            'adviser_id' => 1,
            'library_id' => '3745090404',
            'is_archived' => false
        ]);

        Patron::create([
            'first_name' => 'Antoinnete',
            'middle_name' => '',
            'last_name' => 'Aninang',
            'email' => 'antoinette@gmail.com',
            'contact_number' => '09123456789',
            'type_id' => 1,
            'address' => 'Capiz',
            'school_id' => '21-C0000',
            'department_id' => 1,
            'course_id' => 1,
            'year' => 4,
            'adviser_id' => 1,
            'library_id' => '3689369892',
            'is_archived' => false
        ]);

        Patron::create([
            'first_name' => 'Majomel',
            'middle_name' => '',
            'last_name' => 'Oleo',
            'email' => 'majomel@gmail.com',
            'contact_number' => '09123456789',
            'type_id' => 1,
            'address' => 'Capiz',
            'school_id' => '21-C0000',
            'department_id' => 1,
            'course_id' => 1,
            'year' => 4,
            'adviser_id' => 1,
            'library_id' => '3743148436',
            'is_archived' => false
        ]);

        Book::create([
            'book_number' => '3738229540',
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 4),
            'qty' => 10,
            'available' => 10,
            'is_archived' => false
        ]);

        Book::create([
            'book_number' => '3743346372',
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 4),
            'qty' => 10,
            'available' => 10,
            'is_archived' => false
        ]);
    }
}
