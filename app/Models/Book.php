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
        'isbn',
        'title',
        'publisher',
        'publication_date',
        'edition',
        'volume',
        'pages',
        'references',
        'bibliography',
        'description',
        'category_id',
        'book_image',
        'is_archived'
    ];

    public function bookCopies(){
        return $this->hasMany(BookCopy::class, 'book_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function authors(){
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }

    public function editors(){
        return $this->belongsToMany(Editor::class, 'book_editors', 'book_id', 'editor_id');
    }

    public function illustrators(){
        return $this->belongsToMany(Illustrator::class, 'book_illustrators', 'book_id', 'illustrator_id');
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'book_subjects', 'book_id', 'subject_id');
    }
    public function translators(){
        return $this->belongsToMany(Translator::class, 'book_translators', 'book_id', 'translator_id');
    }
}
