<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sales_id' => $this->uuid,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}
