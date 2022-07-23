<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\Enums\ProductDiscountType;

final class ProductDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $category_id,
        public readonly string $price,
        public readonly null|ProductDiscountType $discount_type = null,
        public readonly null|string $discount = null,
        public null|string $owner_id = null,
        public readonly bool $is_preorder = false,
        public readonly array $images = [],
    ) {}
}
