<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Hootlex\Friendships\Traits\Friendable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPathSrcAttribute()
    {
        if (Storage::exists($this->path)) {
            return asset('storage/' . $this->path);
        }
        return asset('/storage/image/avatar.jpg');
    }

    public function deleteimage()
    {
        if ($this->path && Storage::exists($this->path)) {
            Storage::delete($this->path);
        }
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}