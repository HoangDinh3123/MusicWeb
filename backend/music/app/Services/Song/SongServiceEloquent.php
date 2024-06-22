<?php
namespace App\Services\Song;

use App\Models\Song;
use Carbon\Carbon;
use App\Repositories\Song\SongRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SongServiceEloquent implements SongService 
{
    public function __construct(protected SongRepository $songRepository)
    {
        
    }

    /**
     * @return SongRepository
     */

    public function getAll(): Collection
    {
        return $this->songRepository->all();
    }

    public function getSongByUser(int $id)
    {
        return $this->songRepository->where('songs.user_id', $id)->get();
    }

    public function add(array $attributes): ?Song
    {
        $data = [
            'user_id' => $attributes['user_id'],
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ];

        if (isset($attributes['album_id'])) {
            $data['album_id'] = $attributes['album_id'];
        }

        return $this->songRepository->create($data);
    }

    public function update(array $attributes, int $id)
    {
        unset($attributes['genres'], $attributes['genres_to_delete']);
        return $this->songRepository
            ->where('songs.id', $id)
            ->update($attributes);
    }

    public function updateFile(array $attributes, int $id)
    {
        return $this->songRepository->update([
            'path' => $attributes['path'],
            'image' => $attributes['image'],
        ], $id);
    }


    public function getDetailSongByID(int $id): ?Song
    {
        return $this->songRepository->find($id);
    }

   public function getTrendingSongs(): Collection
   {
        return Song::with('interactions')
        ->withCount(['interactions as play_count_sum' => function ($query) {
            $query->where('created_at', '>=', now()->subDays(30))
                ->select(DB::raw('sum(play_count)'));
        }])
        ->having('play_count_sum', '>', 0)
        ->orderByDesc('play_count_sum')
        ->take(10)
        ->get();
   }

    public function getNewSongs(): Collection
    {
        return $this->songRepository->orderBy('id', 'DESC')->take(12)->get();
    }

    public function search(string $keyword): Collection
    {
        return $this->songRepository->where('name', 'like', '%' . $keyword . '%')->get();
    }

    public function delete(int $id)
    {
        return $this->songRepository->delete($id);
    }
}