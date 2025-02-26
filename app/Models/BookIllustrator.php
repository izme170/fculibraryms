<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookIllustrator extends Model
{
    use HasFactory;
    protected $table = 'book_illustrators';
    protected $primaryKey = 'book_illustrator_id';
    protected $fillable = [
        'book_id',
        'illustrator_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function illustrator(){
        return $this->belongsTo(Illustrator::class, 'illustrator_id');
    }
}
