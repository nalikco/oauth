<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\User\StoreDto;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

readonly class UserRepository
{
    /**
     * Should find a user by ID or throw an exception if not found.
     *
     * @param  int  $id The ID of the user to find.
     * @return ?User The found user, or null if not found.
     *
     * @throws ModelNotFoundException If the user is not found.
     */
    public function findByIdOrFail(int $id): ?User
    {
        // Use the query builder to find a user by ID
        return User::query()->findOrFail($id);
    }

    /**
     * Find a user by email.
     *
     * @param  string  $email The email address of the user.
     * @return ?User The user object if found, null otherwise.
     */
    public function findByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    /**
     * Store a new user in the database.
     *
     * @param  StoreDto  $dto The data transfer object containing the user information.
     * @return User The newly created user.
     */
    public function store(StoreDto $dto): User
    {
        return User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }
}
