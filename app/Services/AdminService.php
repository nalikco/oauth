<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

readonly class AdminService
{
    /**
     * Set the user's status as admin or not.
     *
     * @param  User  $user The user object.
     * @param  bool  $isAdmin Whether the user is an admin or not.
     */
    public function setUserStatus(User $user, bool $isAdmin): void
    {
        if ($isAdmin) {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }
    }
}
