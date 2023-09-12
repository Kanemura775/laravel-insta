<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //To get the owner of the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //To get the categories under a single post
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }
}
