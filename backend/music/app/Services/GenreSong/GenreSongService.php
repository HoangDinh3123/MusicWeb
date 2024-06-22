<?php
namespace App\Services\GenreSong;

use App\Models\GenreSong;
use App\Repositories\GenreSong\GenreSongRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface GenreSongService {
    /**
     * @return GenreSongRepository
     */
    public function addOrUpdate(int $song_id, array $attributes);

    public function delete(int $song_id, array $genres);
    
}