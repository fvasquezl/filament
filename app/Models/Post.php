<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image',
        'user_id',
    ];

    protected $casts = [
        'image' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function houses()
    {
        return $this->belongsToMany(House::class, 'houses_posts');
    }


    /**
     * Accessor para obtener la URL completa de la imagen
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? \Storage::url($this->image) : null;
    }
}
