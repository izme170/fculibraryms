<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialAuthor extends Model
{
    use HasFactory;
    protected $table = 'material_authors';
    protected $primaryKey = 'material_author_id';
    protected $fillable = [
        'material_id',
        'author_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
}
