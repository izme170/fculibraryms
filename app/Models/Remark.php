<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;
    protected $table = 'remarks';
    protected $primaryKey = 'remark_id';
    protected $fillable = [
        'remark',
        'show_in_forms'
    ];

    public function borrowedBooks(){
        return $this->hasMany(BorrowedBook::class, 'remark_id');
    }
}
