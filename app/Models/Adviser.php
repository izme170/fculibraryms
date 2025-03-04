<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;
    protected $table = 'advisers';
    protected $primaryKey = 'adviser_id';
    protected $fillable = [
        'adviser',
        'show_in_forms'
    ];

    public function patrons(){
        return $this->hasMany(Patron::class, 'adviser_id');
    }
}
