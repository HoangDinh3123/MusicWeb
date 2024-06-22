<?php
namespace App\Services\Genre;

use App\Models\Genre;
use App\Repositories\Genre\GenreRepository;
use Illuminate\Support\Collection;

class GenreServiceEloquent implements GenreService 
{
    public function __construct(protected GenreRepository $genreRepository)
    {
        
    }

    /**
     * @return GenreRepository
     */

     public function getAll(): Collection
     {
        return $this->genreRepository->all();
     }

     public function getDetail(int $id): ?Genre
     {
         return $this->genreRepository->find($id);
     }

     public function add(array $attributes): ?Genre
     {
        return $this->genreRepository->create($attributes);
     }

     public function edit(array $attributes, int $id): ?Genre
     {
         return $this->genreRepository->update([
            'name' => $attributes['name'],
         ], $id);
     }

     public function delete(int $id)
    {
        return $this->genreRepository->delete($id);
    }
}