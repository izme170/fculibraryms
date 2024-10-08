<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;
    protected $table = 'advisers';
    protected $primaryKey = 'adviser_id';
    protected $fillable = [
        'adviser'
    ];
}
