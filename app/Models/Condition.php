<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;
    protected $table = 'conditions';
    protected $primaryKey = 'condition_id';
    protected $fillable = [
        'name',
        'show_in_forms'
    ];

    public function materialCopies(){
        return $this->hasMany(MaterialCopy::class, 'condition_id');
    }

    public function borrowedMaterialsBefore(){
        return $this->hasMany(BorrowedMaterial::class, 'condition_before');
    }

    public function borrowedMaterialsAfter(){
        return $this->hasMany(BorrowedMaterial::class, 'condition_after');
    }
}
