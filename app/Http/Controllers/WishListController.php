<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\ProductResource;
use App\Models\Customer;
use App\Models\Enums\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WishListController
{
    public function list(PaginationRequest $request): JsonResource
    {
        /** @var Customer $customer */
        $customer = $request->user();
        $productsQuery = $customer->wishList()
            ->where('status', ProductStatus::ACTIVE);

        return ProductResource::collection($productsQuery->paginate($request->perPage));
    }

    public function addProduct(string $productId, Request $request): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $request->user();
        $customer->wishList()->attach($productId);

        return response()->json(status: Response::HTTP_CREATED);
    }

    public function removeProduct(string $productId, Request $request): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $request->user();
        $customer->wishList()->detach($productId);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
