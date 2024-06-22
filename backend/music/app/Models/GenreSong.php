<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenreSong extends Model
{
    use HasFactory;

    protected $table = 'genre_songs';

    protected $fillable = [
        'song_id',
        'genre_id'
    ];
}
