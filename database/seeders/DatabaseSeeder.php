<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Author;
use App\Models\Role;
use App\Models\User;
use App\Models\PatronType;
use App\Models\Patron;
use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialAuthor;
use App\Models\MaterialCopy;
use App\Models\MaterialEditor;
use App\Models\MaterialIllustrator;
use App\Models\MaterialSubject;
use App\Models\MaterialTranslator;
use App\Models\MaterialType;
use App\Models\BorrowedMaterial;
use App\Models\Course;
use App\Models\Department;
use App\Models\Editor;
use App\Models\FundingSource;
use App\Models\Illustrator;
use App\Models\Marketer;
use App\Models\PatronLogin;
use App\Models\Publisher;
use App\Models\Purpose;
use App\Models\Remark;
use App\Models\Subject;
use App\Models\Translator;
use App\Models\Vendor;
use Database\Factories\AuthorFactory;
use Database\Factories\MaterialFactory;
use Database\Factories\UnreturnedMaterialFactory;
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
            'materials_access' => true,
            'patrons_access' => true,
            'reports_access' => true
        ]);

        Role::create([
            'role' => 'Librarian',
            'materials_access' => true,
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

        // Seed Publishers
        Publisher::factory(20)->create();

        // Seed Material Types
        $materialTypes = [
            'Book',
            'Computer File',
            'Video (Film, Filmstrip, Slide)',
            'Picture, Study Print, Photograph, Chart',
            'Kit (Book and Nonmusical Cassette)',
            'Manuscript Language Material',
            'Maps, Globes and Atlases',
            'Mixed Materials',
            'Music Printed',
            'Three Dimensional Artifact, Object',
            'Sound Recording(Nonmusical)',
            'Serial (Printed Periodical, etc.)',
            'Sound Recording (Musical)'
        ];

        foreach ($materialTypes as $materialType) {
            MaterialType::create(['name' => $materialType]);
        }

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
            'Cookmaterials',
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
        Purpose::create(['purpose' => 'Borrow Materials']);
        Purpose::create(['purpose' => 'Research']);
        Purpose::create(['purpose' => 'WiFi/Internet']);
        Purpose::create(['purpose' => 'Signing of Clearance']);
        Purpose::create(['purpose' => 'Passing of Requirements']);
        Purpose::create(['purpose' => 'Others']);

        // seed funding sources
        FundingSource::create(['name' => 'Library Budget']);
        FundingSource::create(['name' => 'Donation']);

        // seed vendors
        Vendor::factory(20)->create();

        // Seed Materials
        Material::factory(20)->create();

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

        // Material::create([
        //     'material_rfid' => '3738229540',
        //     'accession_number' => 'C-0001',
        //     'title' => fake()->sentence(3),
        //     'isbn' => fake()->isbn13(),
        //     'call_number' => 'BOK 000 A1 2025',
        //     'description' => fake()->sentence(10),
        //     'category_id' => fake()->numberBetween(1, 4),
        // ]);

        // Material::create([
        //     'material_rfid' => '3743346372',
        //     'accession_number' => 'C-0002',
        //     'title' => fake()->sentence(3),
        //     'isbn' => fake()->isbn13(),
        //     'description' => fake()->sentence(10),
        //     'call_number' => 'BOK 000 A1 2025',
        //     'category_id' => fake()->numberBetween(1, 4),
        // ]);

        //seed authors
        Author::factory(20)->create();

        //seed material authors
        for ($i = 0; $i <= 20; $i++) {
            $material = Material::inRandomOrder()->first();
            $author = Author::inRandomOrder()->first();

            $existingRecord = MaterialAuthor::where('material_id', $material->material_id)
                ->where('author_id', $author->author_id)
                ->first();

            if (!$existingRecord) {
                MaterialAuthor::create([
                    'material_id' => $material->material_id,
                    'author_id' => $author->author_id
                ]);
            }
        }

        //seed editors
        Editor::factory(20)->create();

        //seed material editors
        for ($i = 0; $i <= 20; $i++) {
            $material = Material::inRandomOrder()->first();
            $editor = Editor::inRandomOrder()->first();

            $existingRecord = MaterialEditor::where('material_id', $material->material_id)
                ->where('editor_id', $editor->editor_id)
                ->first();

            if (!$existingRecord) {
                MaterialEditor::create([
                    'material_id' => $material->material_id,
                    'editor_id' => $editor->editor_id
                ]);
            }
        }

        //seed illustrators
        Illustrator::factory(20)->create();

        //seed material illustrators
        for ($i = 0; $i <= 20; $i++) {
            $material = Material::inRandomOrder()->first();
            $illustrator = Illustrator::inRandomOrder()->first();

            $existingRecord = MaterialIllustrator::where('material_id', $material->material_id)
                ->where('illustrator_id', $illustrator->illustrator_id)
                ->first();

            if (!$existingRecord) {
                MaterialIllustrator::create([
                    'material_id' => $material->material_id,
                    'illustrator_id' => $illustrator->illustrator_id
                ]);
            }
        }

        //seed subjects
        Subject::factory(20)->create();

        //seed material subjects
        for ($i = 0; $i <= 20; $i++) {
            $material = Material::inRandomOrder()->first();
            $subject = Subject::inRandomOrder()->first();

            $existingRecord = MaterialSubject::where('material_id', $material->material_id)
                ->where('subject_id', $subject->subject_id)
                ->first();

            if (!$existingRecord) {
                MaterialSubject::create([
                    'material_id' => $material->material_id,
                    'subject_id' => $subject->subject_id
                ]);
            }
        }

        //seed translators
        Translator::factory(20)->create();

        //seed material translators
        for ($i = 0; $i <= 20; $i++) {
            $material = Material::inRandomOrder()->first();
            $translator = Translator::inRandomOrder()->first();

            $existingRecord = MaterialTranslator::where('material_id', $material->material_id)
                ->where('translator_id', $translator->translator_id)
                ->first();

            if (!$existingRecord) {
                MaterialTranslator::create([
                    'material_id' => $material->material_id,
                    'translator_id' => $translator->translator_id
                ]);
            }
        }

        // Seed Remarks
        $remarks = [
            'Good',
            'Damaged',
            'Missing Pages',
        ];

        foreach ($remarks as $remark) {
            Remark::create(['remark' => $remark]);
        }

        // seed material copy
        MaterialCopy::factory()->count(5)->create();

        // Seed Borrowed Materials
        BorrowedMaterial::factory(20)->create();

        //Seed Unreturned Material
        for ($i = 0; $i <= 3; $i++) {
            $copy = MaterialCopy::where('is_available', true)->inRandomOrder()->first();

            if (!$copy) {
                continue;
            }

            $patron = Patron::inRandomOrder()->first();
            $user = User::where('role_id', 1)->inRandomOrder()->first();

            $created_at = fake()->dateTimeBetween(now()->startOfDay(), now());
            $due = (clone $created_at)->modify('+' . 60 . 'minutes');

            $existingRecord = BorrowedMaterial::where('copy_id', $copy->copy_id)
                ->where('returned', false)
                ->first();

            if (!$existingRecord) {
                BorrowedMaterial::create([
                    'copy_id' => $copy->copy_id,
                    'patron_id' => $patron->patron_id,
                    'user_id' => $user->user_id,
                    'due_date' => $due,
                    'created_at' => $created_at
                ]);

                //This line will update the material status
                $copy->update(['is_available' => false]);
            }
        }
    }
}
