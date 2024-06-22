<?php
namespace App\Services\Album;

use App\Models\Album;
use App\Repositories\Album\AlbumRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface AlbumService {
    /**
     * @return AlbumRepository
     */
    public function getAll(int $user_id): Collection;
    public function add(array $attributes): ?Album;
    public function updateFile(array $attributes, int $id);
    public function edit(array $attributes, int $id);
    public function getDetail(int $id): ?Album;
    public function delete(int $id);
}