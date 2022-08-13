<?php

declare(strict_types=1);

namespace App\Dto;

final class CustomerDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly null|string $password = null,
        public readonly null|string $address = null,
        public readonly null|string $description = null,
        public readonly null|string $avatar = null,
        public readonly null|string $cover = null,
    ) {}
}
