<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'title',
        'description',
        'release_year',
        'rating',
        'image',
    ];

    protected $casts = [
        'release_year' => 'integer',
        'rating' => 'float',
    ];
    //relation//
    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class, 'movie_id');
    }
}

