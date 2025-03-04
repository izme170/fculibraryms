<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    use HasFactory;
    protected $table = 'translators';
    protected $primaryKey = 'translator_id';
    protected $fillable = [
        'name',
    ];

    public function materials(){
        return $this->hasMany(MaterialTranslator::class, 'translator_id');
    }
}
