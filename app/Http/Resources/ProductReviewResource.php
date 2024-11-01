<?php

namespace App\Http\Resources;

use App\Models\ProductReview;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var ProductReview|JsonResource $this */
        return [
            'id'         => $this->id,
            'customer'   => new ProductOwnerResource($this->customer),
            'product_id' => $this->product_id,
            'body'       => $this->body,
            'rating'     => $this->rating,
            'images'     => array_map(fn(string $image) => asset($image), $this->images),
            'created_at' => $this->created_at,
        ];
    }
}
