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
        'due_date',
        'fine',
        'returned'
    ];

    protected $casts = [
        'returned' => 'datetime'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function patron(){
        return $this->belongsTo(Patron::class, 'patron_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
