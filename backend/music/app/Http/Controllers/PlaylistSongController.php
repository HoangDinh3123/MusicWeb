<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistSong\AddPlayListSongRequest;
use App\Traits\APIResponseTrait;
use App\Services\PlayListSong\PlaylistSongService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaylistSongController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected PlaylistSongService $playlistSongService)
    {
        
    }

    public function add(AddPlayListSongRequest $request) {
        try {
            $data = $this->playlistSongService->add($request->validated());
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse($data, 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function delete(AddPlayListSongRequest $request): JsonResponse
    {
        try {
            $data = $this->playlistSongService->delete($request->validated());
            if($data) {
                return $this->successResponse(null, 'Delete successfully');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 'Data not found.', 404);
        }
    }
}
