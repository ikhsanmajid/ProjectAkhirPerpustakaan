<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'alamat',
        'jenis_identitas',
        'nomor_identitas',
        'no_hp',
        'is_active',
        'remember_token',
        'role'
    ];
    public $incrementing = true;

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
