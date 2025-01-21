<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = ["id"];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function books(){
        return $this->hasMany(Book::class);
    }
}
