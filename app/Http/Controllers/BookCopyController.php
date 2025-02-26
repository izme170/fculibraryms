<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    public function show($id)
    {
        $copy = BookCopy::find($id);
        return view('book_copies.show', compact('copy'));
    }
}
