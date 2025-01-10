<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketer extends Model
{
    use HasFactory;
    protected $table = 'marketers';
    protected $primaryKey = 'marketer_id';
    protected $fillable = [
        'fullname'
    ];

    public function patronLogins() {
        return $this->hasMany(PatronLogin::class, 'marketer_id');
    }
}
