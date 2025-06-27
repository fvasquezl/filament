<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image',
    ];

    protected $appends = ['image_url'];

    public function house()
    {
        return $this->belongsToMany(House::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // If the image path doesn't start with 'posts/', add it
        $imagePath = $this->image;
        if (!str_starts_with($imagePath, 'posts/')) {
            $imagePath = 'posts/' . $imagePath;
        }

        return Storage::url($imagePath);
    }
}
