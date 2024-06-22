<?php
namespace App\Services\GenreSong;

use App\Models\GenreSong;
use App\Repositories\GenreSong\GenreSongRepository;
use Illuminate\Support\Collection;

class GenreSongServiceEloquent implements GenreSongService 
{
    public function __construct(protected GenreSongRepository $genreSongRepository)
    {
        
    }

    /**
     * @return GenreSongRepository
     */
    public function addOrUpdate(int $song_id, array $attributes)
    {
        if(isset($attributes['genres'])) {
            foreach($attributes['genres'] as $genre)
            {
                if($genre != null)
                {
                    return $this->genreSongRepository
                        ->create([
                            'genre_id' => $genre['genre_id'],
                            'song_id' => $song_id,
                        ]);
                }
            }
        }
    }

    public function delete(int $song_id, array $genres)
    {
        foreach($genres as $genre_id )
        {
            if($genre_id != null)
            {
                $this->genreSongRepository
                    ->where([
                        ['song_id', '=', $song_id],
                        ['genre_id', '=', $genre_id]
                    ])
                    ->delete();
            }
        }
    }
}