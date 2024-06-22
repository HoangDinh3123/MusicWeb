<?php

namespace App\Http\Resources\Song;

use App\Http\Resources\Album\AlbumResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\Genre\GenreResource;
use App\Http\Resources\User\UserResource;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        return [
            'id' => $this->resource->id,
            'user' => new UserResource($this->resource->user),
            'album_id' => new AlbumResource($this->resource->album),
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'path' => $this->resource->path,
            'image' => $this->resource->image,
            'genres' =>  GenreResource::collection($this->resource->genres),
            'created_at' => $this->resource->created_at,
            'total_likes' => $this->resource->total_likes,
            'total_play_count' => $this->resource->total_play_count,
            'liked_by_user' => $user ? $this->resource->isLikedByUser($user->id) : false,
        ];
    }
    
}
