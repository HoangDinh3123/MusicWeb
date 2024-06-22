<?php
namespace App\Services\Playlist;

use App\Models\Playlist;
use App\Repositories\Playlist\PlaylistRepository;
use Illuminate\Support\Collection;

class PlaylistServiceEloquent implements PlaylistService 
{
    public function __construct(protected PlaylistRepository $playlistRepository)
    {
        
    }

    /**
     * @return PlaylistRepository
     */
    public function getAll($id): Collection
    {
        return $this->playlistRepository->where('playlists.user_id', $id)->get();
    }

    public function getDetail(int $id): ?Playlist
    {
        return $this->playlistRepository->find($id);
    }

    public function add(int $user_id, array $attributes)
    {
        return $this->playlistRepository->create([
            'user_id' => $user_id,
            'name' => $attributes['name'],
        ]);
    }

    public function edit(int $id, array $attributes)
    {
        return $this->playlistRepository->update([
            'name' => $attributes['name'],
        ], $id);
    }

    public function delete(int $id)
    {
        return $this->playlistRepository->delete($id);
    }
}