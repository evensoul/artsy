<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductResource;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function list(PaginationRequest $paginationRequest, ProductFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = $this->productRepository->findAllByCriteriaQB($productFilterRequest);

        return ProductResource::collection($productsQuery->paginate($paginationRequest->perPage));
    }

    public function vip(PaginationRequest $request): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection($productsQuery->paginate($request->perPage));
    }

    public function recentViewed(PaginationRequest $request): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection($productsQuery->paginate($request->perPage));
    }

    public function wishList(PaginationRequest $request): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection($productsQuery->paginate($request->perPage));
    }

    public function my(PaginationRequest $request): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection($productsQuery->paginate($request->perPage));
    }

    public function show(string $id): JsonResource
    {
        $product = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->findOrFail($id);

        return new ProductFullResource($product);
    }
}
