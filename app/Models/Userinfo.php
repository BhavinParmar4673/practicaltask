<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{

    protected $fillable = [
        'user_id',
        'mobile'
    ];

    public function phones()
    {
        return $this->hasMany(User::class);
    }
}
