<?php

declare(strict_types=1);

namespace App\Dto;

final class ProductReviewDto
{
    public function __construct(
        public readonly string $product_id,
        public readonly string $customer_id,
        public readonly string $body,
        public readonly int $rating,
        public readonly ?string $image = null,
    ) {}
}
