<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum Language: string
{
    case AZERBAIJANI = 'azerbaijani';
    case RUSSIAN = 'russian';

    public function symbol(): string
    {
        return match($this)
        {
            self::AZERBAIJANI => 'az',
            self::RUSSIAN => 'ru',
        };
    }
}
