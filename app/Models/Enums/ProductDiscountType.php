<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum ProductDiscountType: string
{
    case FIXED = 'fixed';
    case PERCENT = 'percent';
}
