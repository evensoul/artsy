<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Product\CreateProductAction;
use App\Dto\ProductDto;
use App\Events\ProductViewed;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductsSearchRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMyFullResource;
use App\Http\Resources\ProductResource;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
    ) {}

    public function list(PaginationRequest $paginationRequest, ProductFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = ProductRepository::findAllByCriteriaQB($productFilterRequest);

        return new ProductCollection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function vip(PaginationRequest $paginationRequest, ProductFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = ProductRepository::findAllByCriteriaQB($productFilterRequest);
        $productsQuery->whereHas('activeVip');

        return ProductResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function recentViewed(PaginationRequest $paginationRequest): JsonResource
    {
        /** @var null|Customer $customer */
        $customer = $paginationRequest->user();

        if (null === $customer) {
            return ProductResource::collection([]);
        }

        $productsQuery = $customer->recentViewedProducts()
            ->where('status', ProductStatus::ACTIVE);

        return ProductResource::collection(
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

    public function search(PaginationRequest $paginationRequest, ProductsSearchRequest $productsSearchRequest): JsonResource
    {
        $productsSearchQuery = Product::search($productsSearchRequest->q);

        return ProductResource::collection(
            $productsSearchQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }
}
