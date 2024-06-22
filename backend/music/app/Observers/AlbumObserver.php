<?php
namespace App\Observers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumObserver
{
    public function deleting(Album $album)
    {
        $album->songs()->delete();
    }
}
