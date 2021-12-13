<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'path'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function getPathSrcAttribute()
    {
        if (Storage::exists($this->path)) {
            return asset('storage/' . $this->path);
        }
        return asset('/storage/image/avatar.jpg');
    }
}