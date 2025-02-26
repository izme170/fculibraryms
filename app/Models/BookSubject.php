<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSubject extends Model
{
    use HasFactory;
    protected $table = 'book_subjects';
    protected $primaryKey = 'book_subject_id';
    protected $fillable = [
        'book_id',
        'subject_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
