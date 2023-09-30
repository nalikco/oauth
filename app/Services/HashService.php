<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Hash;

readonly class HashService
{
    /**
     * Checks if a given value matches a hashed value.
     *
     * @param  string  $value The value to be checked.
     * @param  string  $hashed The hashed value to compare against.
     * @return bool Returns true if the value matches the hashed value, false otherwise.
     */
    public function check(string $value, string $hashed): bool
    {
        return Hash::check($value, $hashed);
    }
}
