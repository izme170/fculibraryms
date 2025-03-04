<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';
    protected $fillable = [
        'name',
    ];

    public function materials(){
        return $this->hasMany(MaterialSubject::class, 'subject_id');
    }
}
