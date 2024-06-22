<?php
namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class UserServiceEloquent implements UserService 
{
    public function __construct(protected UserRepository $userRepository)
    {
        
    }

    /**
     * @return UserRepository
     */


    public function login(array $attributes)
    {
        if(Auth::attempt($attributes)) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $data['token'] = $user->createToken('token')->plainTextToken;
                $data['role'] = $user->role;
                return $data;
            } else {
                return null;
            }
        }

        return null;
    }

    public function register(array $attributes): ?User
    {
        $attributes['role'] = 0;
        return $this->userRepository->create($attributes);
    }

    public function updateInfo(array $attributes)
    {
        return $this->userRepository
            ->where('users.id', $attributes['id'])
            ->update($attributes);
    }

    public function getAll(): Collection
    {
        return $this->userRepository->where([
            'role' => 0
        ])->get();
    }
    
    public function getDetailById(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function getNewUserByMonth(): Collection
    {
        return User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('role', 0)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
    }

    public function getUsersWithMostSongs(): Collection
    {
        return User::withCount('songs')
                ->where('role', 0)
                ->having('songs_count', '>', 0)
                ->orderByDesc('songs_count')
                ->take(10)
                ->get();
    }

    public function getArtist(): Collection
    {
        return User::withCount('songs')
                    ->orderByDesc('songs_count')
                    ->get();
    }

}