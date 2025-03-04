<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTranslator extends Model
{
    use HasFactory;
    protected $table = 'material_translators';
    protected $primaryKey = 'material_translator_id';
    protected $fillable = [
        'material_id',
        'translator_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function translator(){
        return $this->belongsTo(Translator::class, 'translator_id');
    }
}
