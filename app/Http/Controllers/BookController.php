<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::join('categories', 'books.category_id', '=', 'categories.category_id')->orderBy('name')->get();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'author' => ['required'],
            'category_id' => ['required'],
            'qty' => ['required'],
            'book_number' => ['required']
        ]);

        $validated['available'] = $validated['qty'];

        $book = Book::create($validated);

        // Record Activity
        $data = [
            'action' => 'Add Book',
            'book_id' => $book->book_id,
            'user_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/books');
    }
}
