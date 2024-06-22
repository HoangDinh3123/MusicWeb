<?php

namespace App\Http\Controllers;

use App\Http\Requests\Interaction\LikeRequest;
use App\Http\Resources\Interaction\InteractionResource;
use App\Http\Resources\Song\SongResource;
use App\Services\Interaction\InteractionService;
use App\Services\Song\SongService;
use Illuminate\Http\JsonResponse;
use App\Traits\APIResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Song;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected InteractionService $interactionService)
    {
        
    }


    public function like(LikeRequest $request)
    {
        $params = $request->validated();
        $data = $this->interactionService->like($params);

        return $this->successResponse($data);
    }

    public function play(LikeRequest $request)
    {
        $params = $request->validated();
        $data = $this->interactionService->play($params);

        return $this->successResponse('ok');
    }

    public function getLikedSong(int $id): JsonResponse
    {
        try{
            return $this->successResponse(InteractionResource::collection($this->interactionService->getLikedSong($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }
}
