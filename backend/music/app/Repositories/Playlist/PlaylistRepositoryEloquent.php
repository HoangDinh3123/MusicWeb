<?php

namespace App\Repositories\Playlist;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Playlist\PlaylistRepository;
use App\Models\Playlist;
use App\Validators\Playlist\PlaylistValidator;

/**
 * Class PlaylistRepositoryEloquent.
 *
 * @package namespace App\Repositories\Playlist;
 */
class PlaylistRepositoryEloquent extends BaseRepository implements PlaylistRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Playlist::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
