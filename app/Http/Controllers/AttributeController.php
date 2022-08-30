<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AttributeFilterRequest;
use App\Http\Resources\AttributeResource;
use App\Repository\AttributeRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeController
{
    public function __construct(private AttributeRepository $attributeRepository) {}

    public function list(AttributeFilterRequest $filterRequest): JsonResource
    {
        $attributes = $this->attributeRepository
            ->getByCategoryIds($filterRequest->getFilterCategories());

        return AttributeResource::collection($attributes);
    }
}
