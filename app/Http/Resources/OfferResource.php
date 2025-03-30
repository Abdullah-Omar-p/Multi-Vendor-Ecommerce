<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'name' => $this->name,
            'about' => $this->about,
            'custom' => $this->custom,
            'status' => $this->status,
            'no_pieces' => $this->no_pieces,
            'store_id' => $this->store_id,
            'media' => MediaResource::collection($this->whenLoaded('media')), // Eager load media
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
