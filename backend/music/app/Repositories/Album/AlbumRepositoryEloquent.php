<?php

namespace App\Repositories\Album;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Album\AlbumRepository;
use App\Models\Album;
use App\Validators\Album\AlbumValidator;

/**
 * Class AlbumRepositoryEloquent.
 *
 * @package namespace App\Repositories\Album;
 */
class AlbumRepositoryEloquent extends BaseRepository implements AlbumRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Album::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
