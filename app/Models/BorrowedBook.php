<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;
    protected $table = 'borrowed_books';
    protected $primaryKey = 'borrow_id';
    protected $fillable = [
        'book_id',
        'patron_id',
        'user_id',
        'due',
        'is_returned',
        'fine',
        'returned_date'
    ];

}
