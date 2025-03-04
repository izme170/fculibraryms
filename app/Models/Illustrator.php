<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illustrator extends Model
{
    use HasFactory;
    protected $table = 'illustrators';
    protected $primaryKey = 'illustrator_id';
    protected $fillable = [
        'name',
    ];

    public function materials(){
        return $this->hasMany(MaterialIllustrator::class, 'illustrator_id');
    }
}
