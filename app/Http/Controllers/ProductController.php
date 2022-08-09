<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Product\CreateProductAction;
use App\Dto\ProductDto;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductsMyFilterRequest;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMyResource;
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

    public function my(PaginationRequest $request, ProductsMyFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = $this->productRepository->findMyByCriteriaQB($request->user()->id, $productFilterRequest);

        return ProductMyResource::collection($productsQuery->paginate($request->perPage));
    }

    public function show(string $id): JsonResource
    {
        $product = Product::query()
            ->with([
                'owner',
                'category' => ['parent']
            ])
            ->where('status', ProductStatus::ACTIVE)
            ->findOrFail($id);

        return new ProductFullResource($product);
    }

    public function create(CreateProductRequest $request, CreateProductAction $action): JsonResource
    {
        $productDto = new ProductDto(... $request->validatedWithCasts());
        $productDto->owner_id = $request->user()->id;
        $product = $action->execute($productDto);

        return new ProductFullResource($product);
    }
}
