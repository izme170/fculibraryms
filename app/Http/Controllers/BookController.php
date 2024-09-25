<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::join('categories', 'books.category_id', '=', 'categories.category_id')->where('is_archived','=', false)->orderBy('title')->get();
        $borrowed_books = BorrowedBook::leftJoin('books', 'borrowed_books.book_id', '=', 'books.book_id')
            ->leftJoin('patrons', 'borrowed_books.patron_id', '=', 'patrons.patron_id')
            ->leftJoin('users', 'borrowed_books.user_id', '=', 'users.user_id')
            ->select(
                'borrowed_books.*',
                'books.title',
                'patrons.first_name as patron_first_name',
                'users.first_name as user_first_name',
                'patrons.last_name as patron_last_name',
                'users.last_name as user_last_name'
            )
            ->get();

        return view('books.index', compact('books', 'borrowed_books'));
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

    public function update(Request $request, $id){
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

    public function archive($id){
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

    public function newRFID(Request $request, $id){
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
}
