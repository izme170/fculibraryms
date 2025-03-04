<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category',
        'show_in_forms'
    ];

    public function materials(){
        return $this->hasMany(Material::class, 'category_id');
    }
}
