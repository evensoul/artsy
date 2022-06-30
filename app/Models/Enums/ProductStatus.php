<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case MODERATION = 'moderation';
    case DISABLED = 'disabled';
}
