<?php

declare(strict_types=1);

namespace App\Dto\Client\Factories;

use App\Dto\Client\CreateDto;
use App\Dto\Client\UpdateDto;

readonly class CreateUpdateDtoFactory
{
    public static function createFromCreateDto(CreateDto $createDto, string $image = null): UpdateDto
    {
        return new UpdateDto(
            name: $createDto->name,
            brand: $createDto->brand,
            description: $createDto->description,
            redirect: $createDto->redirect,
            link: $createDto->link,
            image: $image,
        );
    }
}
