<?php

declare(strict_types=1);

namespace App\Dto\Client;

use Illuminate\Http\UploadedFile;

readonly class CreateDto
{
    public function __construct(
        public array $name,
        public array $brand,
        public array $description,
        public string $redirect,
        public string $link,
        public ?UploadedFile $image = null,
    ) {
    }
}
