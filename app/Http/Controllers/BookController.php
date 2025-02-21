<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the status, category, and search query parameters from the request
        $status = $request->query('status', 'all');
        $category = $request->query('category', 'all');
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'title');
        $direction = $request->query('direction', 'asc');

        // Create the query to get books
        $query = Book::with(['category', 'authors'])
            ->where('is_archived', '=', false);

        // Apply the status filter if set
        if ($status !== 'all') {
            $query->where(function ($query) use ($status) {
                if ($status === 'available') {
                    $query->where('is_available', true);
                } elseif ($status === 'borrowed') {
                    $query->where('is_available', false)->whereHas('borrowedBooks', function ($subQuery) use ($status) {
                        $subQuery->where('due_date', '>=', now())
                            ->whereNull('returned');
                    });
                } elseif ($status === 'overdue') {
                    $query->where('is_available', false)->whereHas('borrowedBooks', function ($subQuery) use ($status) {
                        $subQuery->where('due_date', '<', now())
                            ->whereNull('returned');;
                    });
                }
            });
        }

        // Apply the category filter if set
        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

        // Apply the search filter if set
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('books.title', 'like', "%{$search}%")
                    ->orWhereHas('authors', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Get the books with pagination
        $books = $query->orderBy($sort, $direction)->paginate(15)->appends([
            'status' => $status,
            'category' => $category,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction
        ]);

        // Get all categories for the filter dropdown
        $categories = Category::orderBy('category')->get();

        // Get all borrowed books
        $borrowed_books = BorrowedBook::all()->keyBy('book_id');

        // Compute status for each book
        $books->each(function ($book) use ($borrowed_books) {
            // Check if the book is available
            if ($book->is_available) {
                $book->status = 'available';
            } else {
                // Find if the book is borrowed and check the status
                $borrowed_book = $borrowed_books->get($book->book_id);

                // Check if the book is borrowed and returned
                if ($borrowed_book && $borrowed_book->returned) {
                    $book->status = 'borrowed';
                } else {
                    // Check if it's overdue or just borrowed
                    $dueDate = $borrowed_book ? Carbon::parse($borrowed_book->due_date) : null;
                    $book->status = $dueDate && Carbon::now()->gt($dueDate) ? 'overdue' : 'borrowed';
                }
            }
        });

        return view('books.index', compact('books', 'categories', 'status', 'category', 'search', 'sort', 'direction'));
    }




    public function create()
    {
        $categories = Category::where('show_in_forms', true)->get();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'author' => ['required', 'array'],
            'author.*' => ['required', 'string'],
            'category_id' => ['required'],
            'book_rfid' => ['required'],
            'book_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);


        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/books', $filenameToStore, 'public');

            if ($path) {
                $validated['book_image'] = str_replace('public/', '', $path); // Save relative path
            } else {
                return back()->withErrors(['book_image' => 'Failed to upload the image.']);
            }
        }

        $book = Book::create($validated);

        // Save authors
        foreach ($validated['author'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author->author_id);
        }

        // Record Activity
        $data = [
            'action' => 'added a new book.',
            'book_id' => $book->book_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/books');
    }

    private $finePerHour = 5;

    public function show($id)
    {
        $book = Book::with('category')
            ->where('books.book_id', $id)
            ->first();
        $categories = Category::all();
        $borrowed_book = BorrowedBook::all()->keyBy('book_id')->get($book->book_id);

        // This code will Assign the book's status
        if ($book->is_available) {
            $book->status = 'available';
        } else {

            // Check if the book is borrowed and returned
            if ($borrowed_book && $borrowed_book->returned) {
                $book->status = 'borrowed';
            } else {
                // Check if it's overdue or just borrowed
                $dueDate = $borrowed_book ? Carbon::parse($borrowed_book->due_date) : null;
                $book->status = $dueDate && Carbon::now()->gt($dueDate) ? 'overdue' : 'borrowed';
            }
        }

        $previous_borrowers = BorrowedBook::with(['patron'])
            ->where('book_id', $id)
            ->get();

        $previous_borrowers->each(function ($borrowed_book) {

            //Checks if the book is returned
            if (!$borrowed_book->returned) {
                $dueDate = Carbon::parse($borrowed_book->due_date);
                $now = Carbon::now();

                //Check if the book is overdue
                if ($now->gt($dueDate)) {
                    $hoursOverdue = $dueDate->diffInHours($now, false);
                    $borrowed_book->fine = $this->finePerHour * (int)$hoursOverdue;
                } else {
                    $borrowed_book->fine = 0;
                }
            }
        });

        return view('books.show', compact('book', 'categories', 'previous_borrowers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'author' => ['required', 'array'],
            'author.*' => ['required', 'string'],
            'category_id' => ['required'],
            // 'book_rfid' => ['required'],
            'book_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        $book = Book::findOrFail($id);

        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/books', $filenameToStore, 'public');

            if ($path) {
                $validated['book_image'] = str_replace('public/', '', $path); // Save relative path
            } else {
                return back()->withErrors(['book_image' => 'Failed to upload the image.']);
            }
        }

        $book->update($validated);

        // Sync authors
        $authorIds = [];
        foreach ($validated['author'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $authorIds[] = $author->author_id;
        }
        $book->authors()->sync($authorIds);

        // Record Activity
        $data = [
            'action' => 'updated a book.',
            'book_id' => $book->book_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'Book has been updated.');
    }

    public function updateImage(Request $request, $id)
    {
        $validated = $request->validate([
            'book_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        $book = Book::find($id);

        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/books', $filenameToStore, 'public');

            // Delete the old image if it exists
            if ($book->book_image) {
                $oldImagePath = public_path('storage/' . $book->book_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            if ($path) {
                $book->book_image = str_replace('public/', '', $path); // Save relative path
                $book->save();
            } else {
                return back()->withErrors(['book_image' => 'Failed to upload the image.']);
            }
        }

        // Record Activity
        $data = [
            'action' => 'updated the image of a book.',
            'book_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'Book image has been updated.');
    }

    public function archive($id)
    {
        Book::find($id)->update(['is_archived' => true]);

        // Record Activity
        $data = [
            'action' => 'archived a book.',
            'book_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/books');
    }

    public function newRFID(Request $request, $id)
    {
        $validated = $request->validate([
            'book_rfid' => 'required|unique:books,book_rfid'
        ]);

        // Record Activity
        $data = [
            'action' => 'assigned new RFID to a book.',
            'book_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'New RFID successfully assigned to the book.');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books-library-management-system' . now() . '.xlsx');
    }
}
