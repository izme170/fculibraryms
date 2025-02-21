<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'book_rfid',
        'accession_number',
        'call_number',
        'isbn',
        'title',
        'description',
        'category_id',
        'book_image',
        'is_available',
        'is_archived'
    ];

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class, 'book_id', 'book_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function authors(){
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }
}
