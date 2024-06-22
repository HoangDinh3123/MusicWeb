<?php

namespace App\Http\Resources\Playlist;

use App\Models\Playlist;
use App\Http\Resources\PlaylistSong\PlaylistSongResource;
use App\Http\Resources\Song\SongResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistDetailResource extends JsonResource
{
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'songs' => SongResource::collection($this->resource->songs),
        ];
    }
}
