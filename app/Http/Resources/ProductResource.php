<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Product $this */
        return [
            'id' => $this->id,
            'image' => asset($this->images[0]),
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'price_with_discount' => $this->priceWithDiscount,
            'rating' => $this->rating,
            'ratings_count' => \random_int(10, 200),
            'is_wish' => \random_int(0, 100) < 5,
            'is_top_seller' => \random_int(0, 100) < 5,
        ];
    }
}
