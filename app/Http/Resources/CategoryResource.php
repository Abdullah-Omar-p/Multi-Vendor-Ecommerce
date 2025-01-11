<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'media' => MediaResource::collection($this->whenLoaded('media')), // Eager load media
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
