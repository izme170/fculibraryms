<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $table = 'authors';
    protected $primaryKey = 'author_id';
    protected $fillable = [
        'name',
    ];

    public function books(){
        return $this->hasMany(BookAuthor::class, 'author_id');
    }
}
