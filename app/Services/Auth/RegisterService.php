<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Dto\Auth\SignUpDto;
use App\Dto\User\StoreDto;
use App\Models\User;
use App\Repositories\UserRepository;

readonly class RegisterService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    /**
     * Register a new user.
     *
     * @param  SignUpDto  $dto The sign-up data transfer object.
     * @return User The registered user.
     */
    public function register(SignUpDto $dto): User
    {
        return $this->userRepository->store(new StoreDto(
            $dto->name,
            $dto->email,
            $dto->password,
        ));
    }
}
