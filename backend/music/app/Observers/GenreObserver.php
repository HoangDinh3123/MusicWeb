<?php

namespace App\Observers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreObserver
{
    public function deleting(Genre $genre)
    {
        $genre->songs()->delete();
    }
}
