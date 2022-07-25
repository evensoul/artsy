<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductRepository
{
    public function findAllByCriteriaQB(ProductFilterRequest $productFilterRequest): Builder
    {
        return Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->when($productFilterRequest->ownerId, function (Builder $qb) use ($productFilterRequest) {
                return $qb->where('owner_id', $productFilterRequest->ownerId);
            })
            ->when(
                !empty($productFilterRequest->_enables)
                && in_array(ProductFilterRequest::VISITOR_OWNER_DATA, $productFilterRequest->_enables),
                fn(Builder $qb) => $qb->with('owner')
            )
            ->orderByDesc('published_at');
    }
}
