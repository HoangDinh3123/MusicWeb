<?php
namespace App\Services\Song;

use App\Models\Song;
use App\Repositories\Song\SongRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface SongService {
    /**
     * @return SongRepository
     */
    public function getAll(): Collection;
    public function add(array $attributes): ?Song;
    public function update(array $attributes, int $id);
    public function getDetailSongByID(int $id): ?Song;
    public function getSongByUser(int $id);
    public function updateFile(array $attributes, int $id);
    public function delete(int $id);
    public function getTrendingSongs(): Collection;
    public function getNewSongs(): Collection;
    public function search(string $keyword): Collection;
}