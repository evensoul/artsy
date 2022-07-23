<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductMyResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Product $this */
        return [
            'id' => $this->id,
            'image' => asset($this->images[0]),
            'title' => $this->title,
            'status' => $this->status,
            'price' => $this->price,
            'price_with_discount' => $this->priceWithDiscount,
            'is_vip' => \random_int(0, 100) < 5,
        ];
    }
}
