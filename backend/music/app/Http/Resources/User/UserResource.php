<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Song\SongResource;
use App\Http\Resources\Album\AlbumResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'image' => $this->resource->image,
            'description' => $this->resource->description,
            'gender' => $this->resource->gender,
            'social_network' => $this->resource->social_network,
            'address' => $this->resource->address,
            'role' => $this->resource->role
        ];
    }
}
