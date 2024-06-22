<?php
namespace App\Services\Interaction;

use App\Models\Interaction;
use App\Repositories\Interaction\InteractionRepository;
use App\Services\Interaction\InteractionService;
use Illuminate\Support\Facades\Auth;
use App\Models\Song;
use Illuminate\Support\Collection;

class InteractionServiceEloquent implements InteractionService
{
    public function __construct(protected InteractionRepository $interactionRepository)
    {
        
    }

    /**
     * @return InteractionRepository
     */

    public function getLikedSong(int $user_id)
    {
        return $this->interactionRepository->where([
            ['interactions.user_id', $user_id],
            ['interactions.liked', '1'],
        ])->get();
    }

     public function like(array $attributes)
     {
        $user = Auth::user();
        
        $interaction = Interaction::firstOrNew(
            ['user_id' => $user->id, 'song_id' => $attributes['song_id']]
        );

        $interaction->liked = !$interaction->liked;
        $data = $interaction->save();
        return $interaction->liked;
     }

     public function play(array $attributes)
     {
        $user = Auth::user();
        
        $interaction = Interaction::firstOrNew(
            ['user_id' => $user->id, 'song_id' => $attributes['song_id']]
        );

        $interaction->play_count += 1;
        $data = $interaction->save();
        return $interaction->play_count;
     }

}