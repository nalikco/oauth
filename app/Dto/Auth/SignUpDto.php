<?php

declare(strict_types=1);

namespace App\Dto\Auth;

readonly class SignUpDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
