<?php

namespace App\Http\Resources;

use Fereron\CategoryTree\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Category|ProductCategoryResource $this */
        return [
            'id' => $this->id,
            'title' => $this->title['en'],
            'parent' => $this->when(null !== $this->parent_id, new ProductCategoryResource($this->parent)),
        ];
    }
}
