<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

final class CategoryController
{
    /**
     * @todo add filter 'name'
     */
    public function list(): JsonResource
    {
        $categoriesQuery = Category::query()
            ->with(['children'])
            ->where('is_active', true)
            ->whereNull('parent_id');

        return CategoryResource::collection($categoriesQuery->get());
    }
}
