<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Collection;
use Laravel\Passport\Passport;

class TokenRepository
{
    /**
     * Retrieves the active tokens grouped by client for a given user.
     *
     * @param  int  $userId The ID of the user.
     * @return Collection The collection of active tokens grouped by client.
     */
    public function getActiveGroupedByClientForUser(int $userId): Collection
    {
        return Passport::token()
            ->newQuery()
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->whereDate('expires_at', '>', now()->toISOString())
            ->with('client')
            ->latest('created_at')
            ->get()
            ->groupBy('client_id');
    }

    /**
     * Retrieves the active tokens for a given client ID.
     *
     * @param int $clientId The ID of the client.
     * @return Collection The collection of active tokens.
     */
    public function getActiveByClientId(int $clientId): Collection
    {
        return Passport::token()
            ->newQuery()
            ->where('client_id', $clientId)
            ->where('revoked', false)
            ->whereDate('expires_at', '>', now()->toISOString())
            ->latest('created_at')
            ->with('user')
            ->get();
    }
}
