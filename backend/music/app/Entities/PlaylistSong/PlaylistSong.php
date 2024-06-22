<?php

namespace App\Entities\PlaylistSong;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PlaylistSong.
 *
 * @package namespace App\Entities\PlaylistSong;
 */
class PlaylistSong extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
