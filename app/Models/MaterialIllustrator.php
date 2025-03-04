<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIllustrator extends Model
{
    use HasFactory;
    protected $table = 'material_illustrators';
    protected $primaryKey = 'material_illustrator_id';
    protected $fillable = [
        'material_id',
        'illustrator_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function illustrator(){
        return $this->belongsTo(Illustrator::class, 'illustrator_id');
    }
}
