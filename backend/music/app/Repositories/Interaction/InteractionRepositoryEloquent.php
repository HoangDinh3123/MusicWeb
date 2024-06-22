<?php

namespace App\Repositories\Interaction;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interaction\InteractionRepository;
use App\Models\Interaction;
use App\Validators\Interaction\InteractionValidator;

/**
 * Class InteractionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Interaction;
 */
class InteractionRepositoryEloquent extends BaseRepository implements InteractionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Interaction::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
