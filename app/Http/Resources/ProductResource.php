<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'discount' => $this->discount,
            'available_pieces' => $this->available_pieces,
            'weight' => $this->weight,
            'color' => $this->color,
            'col_1' => $this->col_1,
            'sold' => $this->sold,
            'rate' => $this->rate,
            'description' => $this->description,
            'media' => MediaResource::collection($this->whenLoaded('media')), // Eager load media
            'col_2' => $this->col_2,
            'col_3' => $this->col_3,
            'col_4' => $this->col_4,
            'about' => $this->about,
            'name' => $this->name,
            'brand' => $this->brand,
            'store_id' => $this->store_id,
            'category_id' => $this->category_id,
            'added_by' => $this->added_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
