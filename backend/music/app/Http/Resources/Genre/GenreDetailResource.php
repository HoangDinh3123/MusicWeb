<?php

namespace App\Http\Resources\Genre;

use App\Http\Resources\Song\SongResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreDetailResource extends JsonResource
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
            'songs' => SongResource::collection($this->resource->songs)  
        ];
    }
}
