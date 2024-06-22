<?php

namespace App\Http\Controllers;

use App\Http\Requests\Playlist\AddPlayListRequest;
use App\Http\Resources\Playlist\PlaylistDetailResource;
use App\Traits\APIResponseTrait;
use App\Http\Resources\Playlist\PlaylistResource;
use App\Services\Playlist\PlaylistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected PlaylistService $playlistService)
    {
        
    }

    public function index(int $id): JsonResponse 
    {
        try{
            return $this->successResponse(PlaylistDetailResource::collection($this->playlistService->getAll($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function detail(int $id): JsonResponse 
    {
        try{
            $playlist = $this->playlistService->getDetail($id);

            if ($playlist->user_id !== auth()->id()) {
                return $this->errorResponse('Unauthorized', 'Unauthorized', 403);
            }
            return $this->successResponse(new PlaylistDetailResource($playlist));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function add(AddPlayListRequest $request, int $user_id) {
        try {
            $data = $this->playlistService->add($user_id, $request->validated());
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new PlaylistDetailResource($this->playlistService->getDetail($data->id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function edit(AddPlayListRequest $request, int $id) {
        try {
            $data = $this->playlistService->edit($id, $request->validated());
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new PlaylistDetailResource($this->playlistService->getDetail($data->id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $data = $this->playlistService->delete($id);
            if($data) {
                return $this->successResponse(null, 'Delete successfully');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 'Data not found.', 404);
        }
    }
}
