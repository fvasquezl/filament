<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{

    protected $fillable = [
        'name',
        'address',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'houses_posts');
    }

}
