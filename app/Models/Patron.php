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
        'library_id',
        'patron_image',
        'is_archived'
    ];
    
    public function getFullnameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function patronLogins()
    {
        return $this->hasMany(PatronLogin::class, 'patron_id');
    }

    public function type()
    {
        return $this->belongsTo(PatronType::class, 'type_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function adviser()
    {
        return $this->belongsTo(Adviser::class, 'adviser_id');
    }

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedMaterial::class, 'patron_id');
    }
}
