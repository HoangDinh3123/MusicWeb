<?php
namespace App\Services\Playlist;

use App\Models\Playlist;
use App\Repositories\Playlist\PlaylistRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface PlaylistService {
    /**
     * @return PlaylistRepository
     */
    public function getAll(int $id): Collection;
    public function getDetail(int $id): ?Playlist;
    public function add(int $user_id, array $attributes);
    public function edit(int $id, array $attributes);
    public function delete(int $id);
    
}