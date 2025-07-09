<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image',
        'user_id',
        'active',
    ];

    protected $casts = [
        'image' => 'string',
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($post) {
            if ($post->isDirty('active') && $post->active) {
                $houseIds = $post->houses()->pluck('houses.id')->toArray();

                static::whereHas('houses', function ($query) use ($houseIds) {
                    $query->whereIn('houses.id', $houseIds);
                })
                    ->where('id', '!=', $post->id)
                    ->where('active', true)
                    ->update(['active' => false]);
            }
        });

        // static::updated(function ($post) {
        //     if ($post->wasChanged('active')) {
        //         broadcast(new PostChanged($post->fresh()))->toOthers();
        //     }
        // });
    }


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
