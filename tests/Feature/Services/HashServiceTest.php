<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Services\HashService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HashServiceTest extends TestCase
{
    /**
     * Test the check method of the HashService class.
     */
    public function test_check(): void
    {
        // Instantiate the HashService class using the Laravel application container
        $service = $this->app->make(HashService::class);

        // Hash the password using the Hash facade
        $hashed = Hash::make('password');

        // Test cases for checking the method
        collect([
            [
                'string' => 'password',
                'expected' => true,
            ], [
                'string' => 'wrong',
                'expected' => false,
            ],
        ])->each(function (array $case) use ($service, $hashed) {
            // Assert that the result of the check method matches the expected value
            $this->assertEquals($case['expected'], $service->check($case['string'], $hashed));
        });
    }
}
