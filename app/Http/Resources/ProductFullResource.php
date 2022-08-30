<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductFullResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Product $this */
        return [
            'id'                    => $this->id,
            'images'                => array_map(fn(string $image) => asset($image), $this->images),
            'title'                 => $this->title,
            'description'           => $this->description,
            'price'                 => $this->price,
            'price_with_discount'   => $this->priceWithDiscount,
            'published_at'          => $this->published_at,
            'rating'                => $this->rating,
            'ratings_count'         => \random_int(10, 200),
            'views_count'           => \random_int(10, 1000),
            'is_preorder'           => $this->is_preorder,
            'is_wish'               => \random_int(0, 100) < 10,
            'has_review_with_photo' => \random_int(0, 100) < 5,
            'owner'                 => new ProductOwnerResource($this->owner),
            'category'              => new ProductCategoryResource($this->categories()->first()),
            'attributes'            => ProductAttributeResource::collection($this->attributesRelation),
        ];
    }
}
