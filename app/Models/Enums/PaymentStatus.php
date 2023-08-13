<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum PaymentStatus: string
{
    case STATUS_CREATED = 'created';
    case STATUS_APPROVED = 'approved';
    case STATUS_DECLINED = 'declined';
}
