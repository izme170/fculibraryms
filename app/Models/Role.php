<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role',
        'materials_access',
        'patrons_access',
        'reports_access'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
