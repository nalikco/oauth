<?php

declare(strict_types=1);

namespace App\Dto\Client;

readonly class UpdateDto
{
    public function __construct(
        public array   $name,
        public array   $brand,
        public array   $description,
        public string  $redirect,
        public string  $link,
        public ?string $image = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name_translated' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
            'redirect' => $this->redirect,
            'link' => $this->link,
            'image' => $this->image,
        ];
    }
}
