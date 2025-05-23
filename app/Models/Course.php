<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $fillable = [
        'course',
        'department_id',
        'show_in_forms'
    ];

    public function patrons(){
        return $this->hasMany(Patron::class, 'course_id');
    }
}
