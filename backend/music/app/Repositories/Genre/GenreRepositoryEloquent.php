<?php

namespace App\Repositories\Genre;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Genre\GenreRepository;
use App\Models\Genre;
use App\Validators\Genre\GenreValidator;

/**
 * Class GenreRepositoryEloquent.
 *
 * @package namespace App\Repositories\Genre;
 */
class GenreRepositoryEloquent extends BaseRepository implements GenreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Genre::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
