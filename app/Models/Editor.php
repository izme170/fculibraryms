<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'editors';
    protected $primaryKey = 'editor_id';
    protected $fillable = [
        'name',
    ];

    public function materials(){
        return $this->hasMany(MaterialEditor::class, 'editor_id');
    }
}
