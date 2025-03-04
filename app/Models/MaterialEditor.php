<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEditor extends Model
{
    use HasFactory;
    protected $table = 'material_editors';
    protected $primaryKey = 'material_editor_id';
    protected $fillable = [
        'material_id',
        'editor_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function editor(){
        return $this->belongsTo(Editor::class, 'editor_id');
    }
}
