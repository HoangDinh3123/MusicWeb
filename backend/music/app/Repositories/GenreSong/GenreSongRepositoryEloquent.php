<?php

namespace App\Repositories\GenreSong;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GenreSong\GenreSongRepository;
use App\Models\GenreSong;
use App\Validators\GenreSong\GenreSongValidator;

/**
 * Class GenreSongRepositoryEloquent.
 *
 * @package namespace App\Repositories\GenreSong;
 */
class GenreSongRepositoryEloquent extends BaseRepository implements GenreSongRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GenreSong::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
