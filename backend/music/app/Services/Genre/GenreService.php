<?php
namespace App\Services\Genre;

use App\Models\Genre;
use App\Repositories\Genre\GenreRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface GenreService {
    /**
     * @return GenreRepository
     */
    public function getAll(): Collection;
    public function add(array $attributes): ?Genre;
    public function edit(array $attributes, int $id): ?Genre;
    public function getDetail(int $id): ?Genre;
    public function delete(int $id);
    
}