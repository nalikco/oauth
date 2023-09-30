<?php

declare(strict_types=1);

namespace App\Dto\Client\Factories;

use App\Dto\Client\CreateDto;
use App\Http\Requests\Client\StoreRequest;

readonly class CreateCreateDtoFactory
{
    public static function fromRequest(StoreRequest $request): CreateDto
    {
        return new CreateDto(
            name: ['en' => $request->validated('name_en'), 'ru' => $request->validated('name_ru')],
            brand: ['en' => $request->validated('brand_en'), 'ru' => $request->validated('brand_ru')],
            description: ['en' => $request->validated('description_en'), 'ru' => $request->validated('description_ru')],
            redirect: $request->validated('redirect_url'),
            link: $request->validated('link'),
            image: $request->validated('image'),
        );
    }
}
