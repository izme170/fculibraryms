<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Patron;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class BorrowBookController extends Controller
{
    public function index()
    {
        $borrowed_books = BorrowedBook::all();

        return view('borrow_books.index', compact('borrowed_books'));
    }
    public function create()
    {
        return view('borrow_books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'library_id' => 'required|exists:patrons,library_id',
            'book_number' => 'required|exists:books,book_number',
            'due' => 'required|date',
            'fine' => 'required|numeric'
        ]);

        $patron = Patron::where('library_id', '=', $validated['library_id'])->first();
        $book = Book::where('book_number', '=', $validated['book_number'])->first();
        $data = [
            'patron_id' => $patron->patron_id,
            'book_id' => $book->book_id,
            'user_id' => Auth::id(),
            'due' => $validated['due'],
            'fine' => $validated['fine']
        ];

        BorrowedBook::create($data);
        $book->decrement('available');
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
        $borrowed_book = BorrowedBook::where('book_id', '=', $book->book_id)->first();

        if ($borrowed_book && is_null($borrowed_book->returned)) {
            $borrowed_book->returned = now();
            $borrowed_book->save();
            $book->increment('available');
        } else {
            return redirect()->back()->with('message_error', 'Book is not found in the Borrowed List');
        }
        return redirect('/borrowed-books');
    }
}
