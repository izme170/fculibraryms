<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookEditor extends Model
{
    use HasFactory;
    protected $table = 'book_editors';
    protected $primaryKey = 'book_editor_id';
    protected $fillable = [
        'book_id',
        'editor_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function editor(){
        return $this->belongsTo(Editor::class, 'editor_id');
    }
}
