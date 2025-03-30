<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'about_store' => $this->about_store,
            'phone' => $this->phone,
            'link_website' => $this->link_website,
            'services' => $this->services,
            'media' => MediaResource::collection($this->whenLoaded('media')), // Eager load media
            'location' => $this->location,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
