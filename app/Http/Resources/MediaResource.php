<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'mediaable_id' => $this->mediaable_id,
            'mediaable_type' => $this->mediaable_type,
            'type' => $this->type,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
