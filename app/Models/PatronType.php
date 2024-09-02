<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatronType extends Model
{
    use HasFactory;
    protected $table = 'patron_types';
    protected $primaryKey = 'type_id';
    protected $fillable = [
        'type'
    ];
}
