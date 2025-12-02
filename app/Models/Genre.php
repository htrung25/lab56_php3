<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    protected $fillable = ['name'];

    // Một thể loại có nhiều phim
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}