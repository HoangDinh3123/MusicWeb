<?php

namespace App\Http\Controllers;

use App\Helper\FileManagerTrait;
use App\Traits\APIResponseTrait;
use App\Http\Requests\Song\AddRequest;
use App\Http\Requests\Song\EditSongRequest;
use App\Http\Resources\Song\SongResource;
use App\Services\Comment\CommentService;
use App\Services\Song\SongService;
use App\Services\GenreSong\GenreSongService;
use App\Services\Interaction\InteractionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SongController extends Controller
{

    use APIResponseTrait, FileManagerTrait;

    public function __construct(
            protected SongService $songService, 
            protected GenreSongService $genreSongService,
            protected InteractionService $interactionService,
            protected CommentService $commentService,
        )
    {
        
    }

    public function index(): JsonResponse 
    {
        try{
            return $this->successResponse(SongResource::collection($this->songService->getAll()));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function newSongs(): JsonResponse
    {
        try {
            $trendingSongs = $this->songService->getNewSongs();
            return $this->successResponse(SongResource::collection($trendingSongs));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Something went wrong', 500);
        }
    }

    public function trendingSongs(): JsonResponse
    {
        try {
            $trendingSongs = $this->songService->getTrendingSongs();
            return $this->successResponse(SongResource::collection($trendingSongs));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Something went wrong', 500);
        }
    }

    public function getDetailById(int $id): JsonResponse 
    {
        try{
            $data = new SongResource($this->songService->getDetailSongByID($id));

            $comments = $this->commentService->getAll($id);

            $detail['song'] = $data;
            $detail['comments'] = $comments;

            return $this->successResponse($detail);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function getSongByUser(int $id): JsonResponse
    {
        try{
            return $this->successResponse(SongResource::collection($this->songService->getSongByUser($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try{
            return $this->successResponse(SongResource::collection($this->songService->search($request->input('keyword'))));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    private function execute(mixed $request, int $id): mixed
    {
        $params = [];
        if ($file = $request->file('image')) {
            $fileData = $this->uploads($file, $id, 'images');

            $params['image'] = $fileData['image'];
        }

        if($mp3 = $request->file('path')) {
            $fileMp3 = $this-> uploadMp3s($mp3, $id);

            $params['path'] = $fileMp3['path'];
        }

        return $params;
    }

    public function addSong(AddRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $data = $this->songService->add($params);

            $file = $this->execute($request, $data->id);

            $this->songService->updateFile($file, $data->id);

            $this->genreSongService->addOrUpdate($data->id, $params);

            DB::commit();

            return $this->successResponse(new SongResource($this->songService->getDetailSongByID($data->id)));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function updateSong(EditSongRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
            $file = $this->execute($request, $id);

            $params = $request->validated();

            if($file) {
                if(isset($file['image'])) {
                    $params['image'] = $file['image'];
                }

                if(isset($file['path'])) {
                    $params['path'] = $file['path'];
                }
            }

            $data = $this->songService->update($params, $id);
            DB::commit();

            if($data) {
                $this->genreSongService->addOrUpdate($id, $params);
                if (isset($params['genres_to_delete'])) {
                    $this->genreSongService->delete($id, $params['genres_to_delete']);
                }
                return $this->successResponse(new SongResource($this->songService->getDetailSongByID($id)));
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception);
        }
        
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $data = $this->songService->delete($id);
            if($data) {
                Storage::deleteDirectory('public/images/' . $id);

                Storage::deleteDirectory('public/mp3s/' . $id);

                return $this->successResponse(null, 'Delete successfully');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 'Data not found.', 404);
        }
    }
}
