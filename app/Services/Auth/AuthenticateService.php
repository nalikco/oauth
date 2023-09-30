<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\HashService;

readonly class AuthenticateService
{
    public function __construct(
        private UserRepository $userRepository,
        private HashService $hashService,
    ) {
    }

    /**
     * Authenticates a user.
     *
     * @param  User  $user The user to authenticate.
     */
    public function authenticate(User $user): void
    {
        auth()->login($user);
    }

    /**
     * Authenticate a user using their email and password.
     *
     * @param  string  $email The user's email.
     * @param  string  $password The user's password.
     * @return User The authenticated user.
     *
     * @throws UnauthorizedException If the credentials are invalid.
     */
    public function authenticateViaCredentials(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            throw new UnauthorizedException();
        }
        if (! $this->hashService->check($password, $user->password)) {
            throw new UnauthorizedException();
        }
        $this->authenticate($user);

        return $user;
    }

    /**
     * Sign out the user.
     */
    public function signOut(): void
    {
        auth()->logout();
    }
}
