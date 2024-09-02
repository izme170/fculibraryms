<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    use HasFactory;
    protected $table = 'patrons';
    protected $primaryKey = 'patron_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_number',
        'type_id',
        'address',
        'school_id',
        'department_id',
        'course_id',
        'year',
        'adviser_id',
        'qrcode',
        'is_archived'
    ];
}
