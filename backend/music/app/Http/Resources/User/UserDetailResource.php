<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Album\AlbumResource;
use App\Http\Resources\Song\SongResource;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'gender' => $this->resource->gender,
            'description' => $this->resource->description,
            'image' => $this->resource->image,
            'address' => $this->resource->address,
            'social_network' => $this->resource->social_network,
            'songs' => SongResource::collection($this->resource->songs),
            'albums' => AlbumResource::collection($this->resource->albums),
            'role' => $this->resource->role
        ];
    }
}
