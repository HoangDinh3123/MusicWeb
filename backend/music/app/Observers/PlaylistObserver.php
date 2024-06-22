<?php

namespace App\Observers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistObserver
{
    public function deleting(Playlist $playlist)
    {
        $playlist->songs()->detach();
    }
}
