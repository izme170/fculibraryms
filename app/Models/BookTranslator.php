<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTranslator extends Model
{
    use HasFactory;
    protected $table = 'book_translators';
    protected $primaryKey = 'book_translator_id';
    protected $fillable = [
        'book_id',
        'translator_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function translator(){
        return $this->belongsTo(Translator::class, 'translator_id');
    }
}
