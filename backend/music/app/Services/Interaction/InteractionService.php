<?php
namespace App\Services\Interaction;

use App\Models\Interaction;
use App\Repositories\Interaction\InteractionRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface InteractionService {
    /**
     * @return InteractionRepository
     */
    public function like(array $attributes);
    public function play(array $attributes);
    public function getLikedSong(int $user_id);
}