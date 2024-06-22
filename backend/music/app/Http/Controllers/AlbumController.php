<?php

namespace App\Http\Controllers;

use App\Helper\FileManagerTrait;
use App\Http\Requests\Album\AddAlbumRequest;
use App\Http\Requests\Album\EditAlbumRequest;
use App\Http\Resources\Album\AlbumDetailResource;
use App\Traits\APIResponseTrait;
use App\Services\Album\AlbumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    use APIResponseTrait, FileManagerTrait;

    public function __construct(protected AlbumService $albumService)
    {
        
    }

    public function index(int $user_id): JsonResponse 
    {
        try{
            return $this->successResponse(AlbumDetailResource::collection($this->albumService->getAll($user_id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function detail(int $id): JsonResponse
    {
        try{
            return $this->successResponse(new AlbumDetailResource($this->albumService->getDetail($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    private function execute(mixed $request, int $id): mixed
    {
        $params = [];
        if ($file = $request['image']) {
            $fileData = $this->uploads($file, $id, 'albums');

            $params['image'] = $fileData['image'];
        }

        return $params;
    }

    public function add(AddAlbumRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            $params = $request->validated();

            $data = $this->albumService->add($params);

            DB::commit();

            $file = $this->execute($params, $data->id);

            $this->albumService->updateFile($file, $data->id);

            DB::commit();
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new AlbumDetailResource($this->albumService->getDetail($data->id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function edit(EditAlbumRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $file = $this->execute($request, $id);

            if($file) {
                if(isset($file['image'])) {
                    $params['image'] = $file['image'];
                }
            }

            $data = $this->albumService->edit($params, $id);

            DB::commit();


            DB::commit();
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new AlbumDetailResource($this->albumService->getDetail($id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $data = $this->albumService->delete($id);
            if($data) {
                Storage::deleteDirectory('public/albums/' . $id);

                return $this->successResponse(null, 'Delete successfully');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 'Data not found.', 404);
        }
    }
}
