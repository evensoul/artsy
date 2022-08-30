<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductsMyFilterRequest;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductRepository
{
    public function findAllByCriteriaQB(ProductFilterRequest $productFilterRequest): Builder
    {
        $orderColumn = $productFilterRequest->getSortColumn() ?: 'published_at';
        $orderDirection = $productFilterRequest->getSortDirection() ?: 'desc';

        return Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_OWNER_ID]),
                fn(Builder $qb) => $qb->where('owner_id', $productFilterRequest->filter[ProductFilterRequest::FILTER_OWNER_ID])
            )
            ->when(
                !empty($productFilterRequest->_enables)
                && in_array(ProductFilterRequest::VISITOR_OWNER_DATA, $productFilterRequest->_enables),
                fn(Builder $qb) => $qb->with('owner')
            )
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_ATTRIBUTE_VALUES_IDS]), function (Builder $productQb) use ($productFilterRequest) {
                    return $productQb->whereHas('attributesRelation', function (Builder $attrQb) use ($productFilterRequest) {
                        return $attrQb->whereIn('id', $productFilterRequest->getFilterAttributeValues());
                    });
                }
            )
            ->orderBy($orderColumn, $orderDirection);
    }

    public function findMyByCriteriaQB(string $ownerId, ProductsMyFilterRequest $productFilterRequest): Builder
    {
        return Product::query()
            ->where('owner_id', $ownerId)
            ->when(
                !empty($productFilterRequest->filter[ProductsMyFilterRequest::FILTER_STATUS]),
                fn(Builder $qb) => $qb->where('status', $productFilterRequest->filter[ProductsMyFilterRequest::FILTER_STATUS])
            )
            ->orderByDesc('published_at');
    }
}
