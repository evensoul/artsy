<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Product\MakeProductVipAction;
use App\Actions\Product\UpdateProductAction;
use App\Dto\ProductDto;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductsMyFilterRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMyFullResource;
use App\Http\Resources\ProductMyResource;
use App\Models\Enums\PaymentStatus;
use App\Models\Enums\PaymentTransactionType;
use App\Models\Enums\ProductStatus;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\VipPackage;
use App\Repository\ProductRepository;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MyProductController
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    public function list(PaginationRequest $paginationRequest, ProductsMyFilterRequest $productFilterRequest): JsonResource
    {
        $productsQuery = $this->productRepository->findMyByCriteriaQB($productFilterRequest->user()->id, $productFilterRequest);

        return ProductMyResource::collection(
            $productsQuery->paginate(perPage: $paginationRequest->perPage, page: $paginationRequest->page)
        );
    }

    public function show(string $id, Request $request): JsonResource
    {
        $product = Product::query()
            ->with([
                'owner',
                'categories' => ['parent']
            ])
            ->where('owner_id', $request->user()->id)
            ->findOrFail($id);

        return new ProductMyFullResource($product);
    }

    public function update(Product $product, UpdateProductRequest $request, UpdateProductAction $action): JsonResource
    {
        if ($request->user()->id !== $product->owner_id) {
            throw new AuthorizationException();
        }

        $productDto = new ProductDto(... $request->validatedWithCasts());
        $productDto->owner_id = $request->user()->id;
        $product = $action->execute($product, $productDto);

        return new ProductFullResource($product);
    }

    public function delete(Product $product, Request $request): JsonResponse
    {
        if ($request->user()->id !== $product->owner_id) {
            throw new AuthorizationException();
        }

        $product->status = ProductStatus::DISABLED;
        $product->save();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

    public function makeVIP(Product $product, VipPackage $package, Request $request, MakeProductVipAction $action): JsonResponse
    {
        if ($request->user()->id !== $product->owner_id) {
            throw new AuthorizationException();
        }

        PaymentTransaction::query()->create([
            'product_id' => $product->id,
            'customer_id' => $request->user()->id,
            'status' => PaymentStatus::STATUS_CREATED,
            'type' => PaymentTransactionType::PRODUCT_PREMIUM,
            'amount' => $package->price,
        ]);

        $action->execute($product, $package);

        return response()->json([
            'redirectUrl' => 'https://google.com'
        ]);
    }
}
