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

    public function patrons(){
        return $this->hasMany(Patron::class, 'department_id');
    }
}
