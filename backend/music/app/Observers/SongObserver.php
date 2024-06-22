<?php

namespace App\Observers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongObserver
{
    public function deleting(Song $song)
    {
        $song->genres()->detach();
        $song->interactions()->delete();
        $song->playlistSongs()->detach();
        $song->comments()->delete();
    }
}
