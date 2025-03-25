<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    protected $fillable = [
        'department',
        'show_in_forms'
    ];

    public function getDepartmentAcronymAttribute()
    {
        $departmentName = $this->department;
        $words = explode(' ', $departmentName);
        $ignoreWords = ['of', 'and', 'the', 'a', 'an', 'in'];

        return implode('', array_map(function ($word) use ($ignoreWords) {
            return (!in_array(strtolower($word), $ignoreWords) && isset($word[0])) ? strtoupper($word[0]) : '';
        }, $words));
    }

    public function patrons(){
        return $this->hasMany(Patron::class, 'department_id');
    }
}
