<?php
namespace App\Services\Album;

use App\Models\Album;
use App\Repositories\Album\AlbumRepository;
use Illuminate\Support\Collection;

class AlbumServiceEloquent implements AlbumService 
{
    public function __construct(protected AlbumRepository $albumRepository)
    {
        
    }

    /**
     * @return albumRepository
     */

     public function getAll(int $user_id): Collection
     {
        return $this->albumRepository->where('albums.user_id', $user_id)->get();
     }

     public function getDetail(int $id): ?Album
     {
         return $this->albumRepository->find($id);
     }

     public function add(array $attributes): ?Album
     {
        return $this->albumRepository->create($attributes);
     }

     public function updateFile(array $attributes, int $id)
    {
        return $this->albumRepository->update([
            'image' => $attributes['image'],
        ], $id);
    }

    public function edit(array $attributes, int $id)
     {
        return $this->albumRepository
            ->where('albums.id', $id)
            ->update($attributes);
     }

    public function delete(int $id)
    {
        return $this->albumRepository->delete($id);
    }
}