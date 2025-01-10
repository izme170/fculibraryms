<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;
    protected $table = 'purposes';
    protected $primaryKey = 'purpose_id';
    protected $fillable = [
        'purpose'
    ];

    public function patronLogins(){
        return $this->hasMany(PatronLogin::class, 'purpose_id');
    }
}
