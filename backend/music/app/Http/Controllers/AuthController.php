<?php

namespace App\Http\Controllers;

use App\Helper\FileManagerTrait;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateInfoRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use App\Traits\APIResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    use APIResponseTrait, FileManagerTrait;

    public function __construct(protected UserService $userService)
    {
        
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try{
            $data = $this->userService->login($request->validated());
            if(!$data) {
                return $this->errorResponse(null, 'Data not found', 404);
            }

            return $this->successResponse($data, 'Login succesfully', 200);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function register(RegisterRequest $request): JsonResponse 
    {
        try {
            $data = $this->userService->register($request->validated());
            if(!$data) {
                return $this->errorResponse(null, 'Somethings went wrong', 400);
            }

            return $this->successResponse(null, 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    private function execute(mixed $request, int $id): mixed
    {

        if ($file = $request['image']) {
            $fileData = $this->uploads($file, $id, 'users');

            $params['image'] = $fileData['image'];
        }

        return $params;
    }

    public function updateInfo(UpdateInfoRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            if(isset($params['image']))
            {
                $file = $this->execute($params, $params['id']);
                $params['image'] = $file['image'];
            }   
            
            $data = $this->userService->updateInfo($params);
            DB::commit();

            return $this->successResponse(new UserResource($this->userService->getDetailById($data)), 'Successful', 200);
        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function info()
    {
        return Auth::user();
    }

    public function index()
    {
        try{
            return $this->successResponse(UserDetailResource::collection($this->userService->getAll()));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function getDetailUser(int $id)
    {
        try{
            return $this->successResponse(new UserDetailResource($this->userService->getDetailById($id)));
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function getNewUsersPerMonth()
    {
        try {
            $usersPerMonth = $this->userService->getNewUserByMonth();
            return $this->successResponse($usersPerMonth, 'Users registered per month', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Something went wrong', 500);
        }
    }

    public function getUsersWithMostSongs()
    {
        try {
            $usersPerMonth = $this->userService->getUsersWithMostSongs();
            return $this->successResponse($usersPerMonth, 'Users registered per month', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Something went wrong', 500);
        }
    }

    public function getArtist()
    {
        try {
            $artist = $this->userService->getArtist();
            return $this->successResponse($artist, 'Users registered per month', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Something went wrong', 500);
        }
    }
}
