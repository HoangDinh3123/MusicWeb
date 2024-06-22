<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'user_id',
        'album_id',
        'name',
        'description',
        'path',
        'image',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_songs');
    }

    public function playlistSongs()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getTotalLikesAttribute()
    {
        return $this->interactions()->where('liked', 1)->count();
    }

    // Accessor to get total play count
    public function getTotalPlayCountAttribute()
    {
        return $this->interactions()->sum('play_count');
    }

    public function isLikedByUser($userId)
    {
        return $this->interactions()
                    ->where('user_id', $userId)
                    ->where('liked', 1)
                    ->exists();
    }
}
