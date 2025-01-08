<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'user_id' => $this->user_id,
            'status' => $this->status,
//            'product_id' => $this->product_id,
            'store_id' => $this->store_id,
//            'offer_id' => $this->offer_id,
            'location' => $this->location,
            'trans_date' => $this->trans_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
