<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Activity;
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

        // Create the query to get books
        $query = Book::join('categories', 'books.category_id', '=', 'categories.category_id')
            ->where('is_archived', '=', false)
            ->select('books.*', 'categories.category as category_name');

        // Apply the status filter if set
        if ($status !== 'all') {
            $query->where(function ($query) use ($status) {
                if ($status === 'available') {
                    $query->where('is_available', true);
                } elseif ($status === 'borrowed' || $status === 'overdue') {
                    $query->where('is_available', false)->whereHas('borrowedBooks', function ($subQuery) use ($status) {
                        if ($status === 'borrowed') {
                            $subQuery->where('due_date', '>=', now());
                        } else {
                            $subQuery->where('due_date', '<', now());
                        }
                    });
                }
            });
        }

        // Apply the category filter if set
        if ($category !== 'all') {
            $query->where('categories.category_id', $category);
        }

        // Apply the search filter if set
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('books.title', 'like', "%{$search}%")
                    ->orWhere('books.author', 'like', "%{$search}%");
            });
        }

        // Get the books with pagination
        $books = $query->orderBy('title')->paginate(10);

        // Get all categories for the filter dropdown
        $categories = Category::all();

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

        return view('books.index', compact('books', 'categories', 'status', 'category', 'search'));
    }




    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'author' => ['required'],
            'category_id' => ['required'],
            'book_number' => ['required']
        ]);

        $book = Book::create($validated);

        // Record Activity
        $data = [
            'action' => 'added a new book.',
            'book_id' => $book->book_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/books');
    }

    public function show($id)
    {
        $book = Book::leftJoin('categories', 'books.category_id', '=', 'categories.category_id')->find($id);
        $categories = Category::all();

        return view('books.show', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required'
        ]);

        $book = Book::find($id)->update($validated);
        // Record Activity
        $data = [
            'action' => 'updated a book.',
            'book_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_succes', 'Book information has been updated.');
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
            'book_number' => 'required|unique:books,book_number'
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
