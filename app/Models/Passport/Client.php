<?php

declare(strict_types=1);

namespace App\Models\Passport;

use Laravel\Passport\Client as PassportClient;

/**
 * @property int $id
 */
class Client extends PassportClient
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name_translated' => 'array',
        'brand' => 'array',
        'description' => 'array',
        'grant_types' => 'array',
        'scopes' => 'array',
        'personal_access_client' => 'bool',
        'password_client' => 'bool',
        'revoked' => 'bool',
    ];
}
