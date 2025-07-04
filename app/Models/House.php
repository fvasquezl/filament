<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{

    protected $fillable = [
        'name',
        'address',
        'user_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
