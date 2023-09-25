<?php

declare(strict_types=1);

namespace App\Service\KapitalBank;

class PurchaseDto
{
    public function __construct(
        public string $amount,
        public string $productId,
        public string $productTitle,
    ) {}
}
