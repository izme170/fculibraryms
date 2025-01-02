<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Role;
use App\Models\User;
use App\Models\PatronType;
use App\Models\Patron;
use App\Models\Category;
use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Course;
use App\Models\Department;
use App\Models\Marketer;
use App\Models\PatronLogin;
use App\Models\Purpose;
use Database\Factories\BookFactory;
use Database\Factories\UnreturnedBookFactory;
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
            'role' => 'Admin',
            'books_access' => true,
            'patrons_access' => true,
            'reports_access' => true
        ]);

        Role::create([
            'role' => 'Librarian',
            'books_access' => true,
            'patrons_access' => true,
            'reports_access' => true
        ]);

        // Seed Users
        User::factory(20)->create();

        // Seed Patron Types
        PatronType::create(['type' => 'Student']);
        PatronType::create(['type' => 'Faculty']);
        PatronType::create(['type' => 'Guest']);

        // Seed Department
        $departments = [
            'College of Arts and Sciences',
            'College of Business and Accountancy',
            'College of Computer Studies',
            'College of Criminal Justice Education',
            'College of Engineering',
            'College of Hospitality and Tourism Management',
            'College of Nursing',
            'College of Teacher Education',
            'Graduate School',
            'Senior High School'
        ];
        foreach ($departments as $department) {
            Department::create(['department' => $department]);
        }

        // Seed Course
        $courses = [
            'Bachelor of Arts' => 1,
            'Bachelor of Science in Biology' => 1,
            'Bachelor of Science in Psychology' => 1,
            'Bachelor of Science in Social Work' => 1,
            'Bachelor of Science in Accountancy' => 2,
            'Bachelor of Science in Business Administration' => 2,
            'Bachelor of Science in Intrepreneurship' => 2,
            'Bachelor of Science in Computer Science' => 3,
            'Bachelor of Science in Information Technology' => 3,
            'Bachelor of Science in Criminology' => 4,
            'Bachelor of Science in Electronics Engineering' => 5,
            'Bachelor of Science in Hospitality Management' => 6,
            'Bachelor of Science in Tourism Management' => 6,
            'Bachelor of Science in Nursing' => 7,
            'Bachelor of Elementary Education' => 8,
            'Bachelor of Secondary Education' => 8,
            'Bachelor of Culture and Arts Education' => 8,
            'Bachelor of Early Childhood Education' => 8,
            'Bachelor of Physical Education' => 8,
            'Bachelor of Special Needs Education' => 8,
        ];

        foreach ($courses as $course => $department_id) {
            Course::create([
                'course' => $course,
                'department_id' => $department_id
            ]);
        }

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

        // Seed Purposes
        Purpose::create(['purpose' => 'Read']);
        Purpose::create(['purpose' => 'Borrow Books']);
        Purpose::create(['purpose' => 'Research']);
        Purpose::create(['purpose' => 'WiFi/Internet']);

        // Seed Books
        Book::factory(20)->create();

        // Seed Marketer
        Marketer::factory(10)->create();

        // Seed Patron Logins
        PatronLogin::factory(30)->create();

        // Seed Admin
        User::create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'role_id' => 1,
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => fake()->phoneNumber(),
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'is_archived' => false
        ]);

        // Seed User
        User::create([
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'role_id' => 2,
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => fake()->phoneNumber(),
            'username' => 'user',
            'password' => bcrypt('user'),
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
            'department_id' => 3,
            'course_id' => 9,
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
            'department_id' => 3,
            'course_id' => 9,
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
            'department_id' => 3,
            'course_id' => 9,
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
            'department_id' => 3,
            'course_id' => 9,
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
        ]);

        Book::create([
            'book_number' => '3743346372',
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'category_id' => fake()->numberBetween(1, 4),
        ]);

        // Seed Borrowed Books
        BorrowedBook::factory(20)->create();

        //Seed Unreturned Book
        for ($i = 0; $i <= 3; $i++) {
            $book = Book::where('is_available', true)->inRandomOrder()->first();

            if (!$book) {
                continue;
            }

            $patron = Patron::inRandomOrder()->first();
            $user = User::where('role_id', 1)->inRandomOrder()->first();

            $created_at = fake()->dateTimeBetween(now()->startOfDay(), now());
            $due = (clone $created_at)->modify('+' . 60 . 'minutes');

            $existingRecord = BorrowedBook::where('book_id', $book->book_id)
                ->where('returned', false)
                ->first();

            if (!$existingRecord) {
                BorrowedBook::create([
                    'book_id' => $book->book_id,
                    'patron_id' => $patron->patron_id,
                    'user_id' => $user->user_id,
                    'due_date' => $due,
                    'created_at' => $created_at
                ]);

                //This line will update the book status
                $book->update(['is_available' => false]);
            }
        }
    }
}
