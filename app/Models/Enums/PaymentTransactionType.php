<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum PaymentTransactionType: string
{
    case PRODUCT_PREMIUM = 'product_premium';
}
