<?php

declare(strict_types=1);

namespace App\Dto\Auth\Factories;

use App\Dto\Auth\SignUpDto;
use App\Http\Requests\Auth\SignUpRequest;

readonly class CreateSignUpDtoFactory
{
    /**
     * Creates a StoreDto object from a SignUpRequest object.
     *
     * @param  SignUpRequest  $request The SignUpRequest object.
     * @return SignUpDto The created SignUpDto object.
     */
    public static function createFromRequest(SignUpRequest $request): SignUpDto
    {
        return self::createFromArray($request->validated());
    }

    /**
     * Creates a StoreDto object from an array of data.
     *
     * @param  array  $data The array of data containing the following keys:
     *                    - 'name': The name of the user.
     *                    - 'email': The email of the user.
     *                    - 'password': The password of the user.
     * @return SignUpDto The created SignUpDto object.
     */
    public static function createFromArray(array $data): SignUpDto
    {
        return new SignUpDto(
            $data['name'],
            $data['email'],
            $data['password'],
        );
    }
}
