<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatronLogin extends Model
{
    use HasFactory;
    protected $table = 'patron_logins';
    protected $primaryKey = 'login_id';
    protected $fillable = [
        'patron_id',
        'purpose_id',
        'marketer_id'
    ];
}
