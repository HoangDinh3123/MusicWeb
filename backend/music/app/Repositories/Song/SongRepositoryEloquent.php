<?php

namespace App\Repositories\Song;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Song\SongRepository;
use App\Models\Song;
use App\Validators\Song\SongValidator;

/**
 * Class SongRepositoryEloquent.
 *
 * @package namespace App\Repositories\Song;
 */
class SongRepositoryEloquent extends BaseRepository implements SongRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Song::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
