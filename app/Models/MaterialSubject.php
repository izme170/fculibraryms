<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSubject extends Model
{
    use HasFactory;
    protected $table = 'material_subjects';
    protected $primaryKey = 'material_subject_id';
    protected $fillable = [
        'material_id',
        'subject_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
