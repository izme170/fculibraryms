<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;
    protected $table = 'publishers';
    protected $primaryKey = 'publisher_id';
    protected $fillable = [
        'name'
    ];

    public function materials(){
        return $this->hasMany(Material::class, 'publisher_id');
    }
}
