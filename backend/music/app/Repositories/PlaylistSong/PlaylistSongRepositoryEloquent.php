<?php

namespace App\Repositories\PlaylistSong;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlaylistSong\PlaylistSongRepository;
use App\Models\PlaylistSong;
use App\Validators\PlaylistSong\PlaylistSongValidator;

/**
 * Class PlaylistSongRepositoryEloquent.
 *
 * @package namespace App\Repositories\PlaylistSong;
 */
class PlaylistSongRepositoryEloquent extends BaseRepository implements PlaylistSongRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlaylistSong::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
