<?php

declare(strict_types=1);

namespace App\Actions\Authenticate;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

readonly class GetAuthenticatedUserAction
{
    /**
     * Returns the authenticated user.
     *
     * @return User the authenticated user.
     *
     * @throws UnauthorizedException if the user is not authenticated.
     */
    public function __invoke(): User
    {
        $user = Auth::user();
        if ($user == null) {
            throw new UnauthorizedException();
        }

        return $user;
    }
}
