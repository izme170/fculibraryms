<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

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

        Book::create($validated);
        return redirect('/admin/books');
    }
}
