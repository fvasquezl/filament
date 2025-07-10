<?php

namespace App\Models;

use App\Events\PostActivated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

                // Usar withoutEvents para evitar disparar eventos en cascada
                static::withoutEvents(function () use ($post, $houseIds) {
                    static::whereIn('id', function ($query) use ($houseIds) {
                        $query->select('post_id')
                              ->from('houses_posts')
                              ->whereIn('house_id', $houseIds);
                    })
                        ->where('id', '!=', $post->id)
                        ->where('active', true)
                        ->update(['active' => false]);
                });
            }
        });

        static::updated(function ($post) {
            if ($post->wasChanged('active')) {
                PostActivated::dispatch($post->fresh()->load('houses'));
            }
        });
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
        return $this->image ? Storage::url($this->image) : null;
    }

}
