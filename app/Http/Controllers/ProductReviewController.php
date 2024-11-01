<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ProductReview\CreateProductReviewAction;
use App\Dto\ProductReviewDto;
use App\Http\Requests\CreateProductReviewRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\ProductReviewResource;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\ProductReview;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewController
{
    public function list(string $productId, PaginationRequest $paginationRequest): JsonResource
    {
        $reviewsQuery = ProductReview::query()
            ->where('product_id', $productId)
            ->where('is_moderated', true)
            ->latest();

        return ProductReviewResource::collection(
            $reviewsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function create(CreateProductReviewRequest $request, CreateProductReviewAction $action): ProductReviewResource
    {
        $review = $action->execute(new ProductReviewDto(... $request->validated()));

        return new ProductReviewResource($review);
    }

    public function listByCustomer(string $customerId, PaginationRequest $paginationRequest): JsonResource
    {
        $reviewsQuery = ProductReview::query()
            ->where('is_moderated', true)
            ->whereHas('product', function (Builder $query) use ($customerId) {
                return $query
                    ->where('owner_id', $customerId)
                    ->where('status', ProductStatus::ACTIVE);
            })
            ->latest();

        return ProductReviewResource::collection(
            $reviewsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }
}
