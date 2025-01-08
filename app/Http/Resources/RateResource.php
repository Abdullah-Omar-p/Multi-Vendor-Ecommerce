<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rate' => $this->rate,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'comment_id' => $this->comment_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
