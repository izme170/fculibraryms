<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'role_id',
        'email',
        'contact_number',
        'username',
        'password',
        'is_archived'
    ];
    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
