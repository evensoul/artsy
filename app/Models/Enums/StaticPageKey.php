<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum StaticPageKey: string
{
    case HOW_WORKS = 'how_works';
    case SAFE_SHOPPING = 'safe_shopping';
    case TERMS_OF_USE = 'terms_of_use';
    case CONFIDENTIALITY = 'confidentiality';
}
