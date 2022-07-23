<?php

namespace App\Http\Resources;

use Fereron\CategoryTree\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

final class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Category $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_new' => $this->created_at->gt(now()->subWeek()), // todo discuss
            'children' => CategoryResource::collection($this->children),
        ];
    }
}
