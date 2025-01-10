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
        'marketer_id',
        'login_at',
        'logout_at'
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime'
    ];

    public function patron()
    {
        return $this->belongsTo(Patron::class, 'patron_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id');
    }

    public function marketer()
    {
        return $this->belongsTo(Marketer::class, 'marketer_id');
    }
}
