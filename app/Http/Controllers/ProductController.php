<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Product\CreateProductAction;
use App\Dto\ProductDto;
use App\Events\ProductViewed;
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
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly Dispatcher $dispatcher,
    ) {}

    public function list(PaginationRequest $paginationRequest, ProductFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = $this->productRepository->findAllByCriteriaQB($productFilterRequest);

        return ProductResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function vip(PaginationRequest $paginationRequest): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function recentViewed(PaginationRequest $paginationRequest): JsonResource
    {
        $productsQuery = Product::query()
            ->where('status', ProductStatus::ACTIVE)
            ->inRandomOrder();

        return ProductResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function my(PaginationRequest $paginationRequest, ProductsMyFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = $this->productRepository->findMyByCriteriaQB($productFilterRequest->user()->id, $productFilterRequest);

        return ProductMyResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function show(string $id): JsonResource
    {
        $product = Product::query()
            ->with([
                'owner',
                'categories' => ['parent']
            ])
            ->where('status', ProductStatus::ACTIVE)
            ->findOrFail($id);

        $this->dispatcher->dispatch(new ProductViewed($product));

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
