<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductsMyFilterRequest;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public static function findAllByCriteriaQB(Request|ProductFilterRequest $productFilterRequest): Builder
    {
        $orderColumn = method_exists($productFilterRequest, 'getSortColumn') && $productFilterRequest->getSortColumn()
            ? $productFilterRequest->getSortColumn()
            : 'published_at';
        $orderDirection = method_exists($productFilterRequest, 'getSortDirection') && $productFilterRequest->getSortDirection()
            ? $productFilterRequest->getSortDirection()
            : 'desc';

        return Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_OWNER_ID]),
                fn(Builder $qb) => $qb->where('owner_id', $productFilterRequest->filter[ProductFilterRequest::FILTER_OWNER_ID])
            )
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_ATTRIBUTE_VALUES_IDS]), function (Builder $productQb) use ($productFilterRequest) {
                    return $productQb->whereHas('attributesRelation', function (Builder $attrQb) use ($productFilterRequest) {
                        return $attrQb->whereIn('id', $productFilterRequest->getFilterAttributeValues());
                    });
                }
            )
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_PRICE_MIN]),
                fn(Builder $qb) => $qb->where('price', '>', $productFilterRequest->filter[ProductFilterRequest::FILTER_PRICE_MIN])
            )
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_PRICE_MAX]),
                fn(Builder $qb) => $qb->where('price', '<', $productFilterRequest->filter[ProductFilterRequest::FILTER_PRICE_MAX])
            )
            ->when(
                !empty($productFilterRequest->filter[ProductFilterRequest::FILTER_HAS_DISCOUNT]),
                fn(Builder $qb) => $qb->whereNotNull('discount')
            )
//            ->when(
//                !empty($productFilterRequest->_enables)
//                && in_array(ProductFilterRequest::VISITOR_PRICE_RANGE, $productFilterRequest->_enables),
//                function (Builder $qb) {
//                    $minQuery = clone $qb;
//                    return $qb
//                        ->selectSub($minQuery->select(DB::raw('MIN(price) as price_min, MAX(price) as price_max')), 'price_range');
//                }
//            )
            ->orderBy($orderColumn, $orderDirection);
    }

    public static function getPriceRange(Request|ProductFilterRequest $productFilterRequest): array
    {
        $qb = self::findAllByCriteriaQB($productFilterRequest);
        $result = $qb
            ->select(DB::raw('MIN(price) as price_min, MAX(price) as price_max'))
            ->first();

        return [$result->price_min, $result->price_max];
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
