<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;
    protected $table = 'book_authors';
    protected $primaryKey = 'book_author_id';
    protected $fillable = [
        'book_id',
        'author_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
}
