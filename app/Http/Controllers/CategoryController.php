<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryFullResource;
use App\Http\Resources\CategoryResource;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Fereron\CategoryTree\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

final class CategoryController
{
    /**
     * @todo add filter 'name'
     */
    public function tree(): JsonResource
    {
        $categoriesQuery = Category::query()
            ->with(['children'])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order');

        return CategoryResource::collection($categoriesQuery->get());
    }

    public function show(Category $category): CategoryFullResource
    {
        return new CategoryFullResource($category);
    }

    public function listByCustomer(Customer $customer): JsonResource
    {
        $categoriesQuery = Category::query()
            ->whereHas('products', function (Builder $query) use ($customer) {
                return $query
                    ->where('owner_id', $customer->id)
                    ->where('status', ProductStatus::ACTIVE);
            });

        return CategoryResource::collection($categoriesQuery->get());
    }
}
