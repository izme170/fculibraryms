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

    public function books(){
        return $this->hasMany(BookIllustrator::class, 'illustrator_id');
    }
}
