<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activities';
    protected $primaryKey = 'activity_id';
    protected $fillable = [
        'action',
        'material_id',
        'patron_id',
        'user_id',
        'initiator_id'
    ];

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function patron(){
        return $this->belongsTo(Patron::class, 'patron_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function initiator(){
        return $this->belongsTo(User::class, 'initiator_id', 'user_id');
    }
}
