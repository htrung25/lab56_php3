<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'poster',
        'intro',
        'release_date',
        'genre_id'
    ];
    protected $casts = [
        'release_date' => 'date',   // Hoặc 'datetime' nếu có giờ
    ];

    protected $dates = ['release_date'];

    // Một phim thuộc về một thể loại
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
