<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Patron;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class BorrowBookController extends Controller
{
    private $finePerHour = 5;
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = BorrowedBook::with(['book:book_id,title', 'patron:patron_id,first_name,last_name', 'user:user_id,first_name,last_name']);

        if (!empty($search)) {
            $query->whereHas('book', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })->orWhereHas('patron', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($status !== 'all') {
            if ($status === 'returned') {
                $query->whereNotNull('returned');
            } elseif ($status === 'borrowed') {
                $query->whereNull('returned')
                    ->where('due_date', '>=', now());
            } elseif ($status === 'overdue') {
                $query->whereNull('returned')
                ->where('due_date', '<', now());
            }
        }

        $borrowed_books = $query->orderByDesc('created_at')
            ->paginate(10);

        $borrowed_books->each(function ($borrowed_book) {
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

        return view('borrow_books.index', compact(['borrowed_books', 'search', 'status']));
    }

    public function create()
    {
        return view('borrow_books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'library_id' => 'required|exists:patrons,library_id',
            'book_number' => 'required|exists:books,book_number'
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();
        $book = Book::where('book_number', '=', $validated['book_number'])->first();
        $data = [
            'patron_id' => $patron->patron_id,
            'book_id' => $book->book_id,
            'user_id' => Auth::id(),
        ];

        if ($request['due'] == 'oneHour') {
            $data['due_date'] = Carbon::now()->addHours(1);
        } else {
            $data['due_date'] = Carbon::now()->adddays(1);
        }

        BorrowedBook::create($data);
        $book->update(['is_available' => false]);
        return redirect()->back();
    }

    public function edit()
    {
        return view('borrow_books.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'book_number' => 'required|exists:books,book_number'
        ]);

        $book = Book::where('book_number', '=', $validated['book_number'])->first();
        $borrowed_book = BorrowedBook::where('book_id', '=', $book->book_id)->whereNull('returned')->first();

        if ($borrowed_book) {
            $dueDate = Carbon::parse($borrowed_book->due_date);
            $now = Carbon::now();
            $borrowed_book->returned = $now;

            // Check if the book is overdue
            if ($now->gt($dueDate)) {
                $hoursOverdue = $dueDate->diffInHours($now);
                $borrowed_book->fine = $this->finePerHour * (int)$hoursOverdue;
            } else {
                $borrowed_book->fine = 0;
            }

            $borrowed_book->save();

            // Make the book available
            $book->update(['is_available' => true]);
        } else {
            return redirect()->back()->with('message_error', 'Book is not found in the Borrowed List');
        }
        return redirect('/books');
    }
}
