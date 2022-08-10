<?php

namespace App\Http\Resources;

use Fereron\CategoryTree\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

final class CategoryFullResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Category $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'parent' => new ProductCategoryResource($this->parent),
            'children' => CategoryResource::collection($this->children),
        ];
    }
}
