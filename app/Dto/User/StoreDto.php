<?php

declare(strict_types=1);

namespace App\Dto\User;

readonly class StoreDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
