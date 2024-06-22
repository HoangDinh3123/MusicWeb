<?php
namespace App\Services\PlaylistSong;

use App\Models\PlaylistSong;
use App\Repositories\PlaylistSong\PlaylistSongRepository;
use Illuminate\Support\Collection;

class PlaylistSongServiceEloquent implements PlayListSongService 
{
    public function __construct(protected PlaylistSongRepository $playlistSongRepository)
    {
        
    }

    /**
     * @return PlaylistSongRepository
     */

    public function add(array $attributes)
    {
        return $this->playlistSongRepository->create([
            'playlist_id' => $attributes['playlist_id'],
            'song_id' => $attributes['song_id'],
        ]);
    }


    public function delete(array $attributes)
    {
        return $this->playlistSongRepository
            ->where([
                ['playlist_id', '=', $attributes['playlist_id']],
                ['song_id', '=', $attributes['song_id']],
            ])
            ->delete();
    }
}