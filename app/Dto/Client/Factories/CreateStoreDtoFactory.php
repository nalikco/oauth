<?php

declare(strict_types=1);

namespace App\Dto\Client\Factories;

use App\Dto\Client\CreateDto;
use App\Dto\Client\StoreDto;

readonly class CreateStoreDtoFactory
{
    public static function createFromCreateDto(CreateDto $createDto): StoreDto
    {
        return new StoreDto(
            name: $createDto->name,
            brand: $createDto->brand,
            description: $createDto->description,
            redirect: $createDto->redirect,
            link: $createDto->link,
        );
    }
}
