<?php

namespace App\Http\Resources\Interaction;

use App\Models\Song;
use App\Http\Resources\Song\SongResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
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
            new SongResource($this->resource->song),
        ];
    }
}
