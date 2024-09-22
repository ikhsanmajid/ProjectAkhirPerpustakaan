<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'email', 'password', 'nama', 'is_active', 'remember_token'
    ];
    
}
