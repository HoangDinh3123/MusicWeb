<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaylistSong extends Model
{
    use HasFactory;

    protected $table = 'playlist_songs';

    protected $fillable = [
        'song_id',
        'playlist_id',
    ];
}
