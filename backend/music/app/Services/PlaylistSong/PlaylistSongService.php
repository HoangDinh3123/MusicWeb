<?php
namespace App\Services\PlayListSong;

use App\Models\PlaylistSong;
use App\Repositories\PlaylistSong\PlaylistSongRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface PlaylistSongService {
    /**
     * @return PlaylistSongRepository
     */
    public function add(array $attributes);
    public function delete(array $attributes);
    
}