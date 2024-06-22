<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genre\AddGenreRequest;
use App\Http\Resources\Genre\GenreDetailResource;
use App\Http\Resources\Genre\GenreResource;
use App\Services\Genre\GenreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\APIResponseTrait;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected GenreService $genreService)
    {
        
    }

    public function index(): JsonResponse
    {
        try{
            return $this->successResponse(GenreResource::collection($this->genreService->getAll()));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function detail(int $id): JsonResponse
    {
        try{
            return $this->successResponse(new GenreDetailResource($this->genreService->getDetail($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function add(AddGenreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $this->genreService->add($request->validated());
            DB::commit();

            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new GenreResource($this->genreService->getDetail($data->id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function edit(AddGenreRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $this->genreService->edit($request->validated(), $id);
            DB::commit();

            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(new GenreResource($this->genreService->getDetail($id)), 'Successful', 200);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function delete(int $id) 
    {
        try {
            $data = $this->genreService->delete($id);
            if($data) {
                return $this->successResponse(null, 'Delete successfully');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse(null, 'Data not found.', 404);
        }
    }
}
