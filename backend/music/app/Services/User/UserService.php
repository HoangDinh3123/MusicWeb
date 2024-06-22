<?php
namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface UserService {
    /**
     * @return UserRepository
     */
    public function getAll(): Collection;
    public function getDetailById(int $id);
    public function login(array $attributes);
    public function register(array $attributes): ?User; 
    public function updateInfo(array $attributes);
    
    public function getNewUserByMonth(): Collection; 
    public function getUsersWithMostSongs(): Collection;
    public function getArtist(): Collection;

}