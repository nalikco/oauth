<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Passport\Client;
use App\Models\User;
use App\Repositories\TokenRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TokenRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the getActiveGroupedByClientForUser method.
     *
     * This method retrieves the active tokens grouped by client for a specific user. It creates
     * test data and asserts the expected results.
     */
    public function test_get_active_grouped_by_client_for_user(): void
    {
        // Create the token repository instance
        $repository = $this->app->make(TokenRepository::class);

        // Create three client instances
        $clientOne = Factory::factoryForModel(Client::class)->create();
        $clientTwo = Factory::factoryForModel(Client::class)->create();
        $clientThree = Factory::factoryForModel(Client::class)->create();

        // Create two user instances
        $user = User::factory()->create();
        $differentUser = User::factory()->create();

        // Create four tokens for clientOne with different properties
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 1',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ])->refresh();
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 2',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ])->refresh();
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 3 (revoked)',
            'revoked' => true,
            'expires_at' => now()->addDay(),
        ]);
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 4 (expired)',
            'revoked' => true,
            'expires_at' => now()->addDay(),
        ]);

        // Create a token for clientTwo
        $clientTwo->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 2 Token',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ]);

        // Create a token for clientThree with a different user
        $clientThree->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $differentUser->id,
            'name' => 'Client 3 Token (different user)',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ]);

        // Call the getActiveGroupedByClientForUser method
        $result = $repository->getActiveGroupedByClientForUser($user->id);

        // Assert the expected result count
        $this->assertEquals(2, $result->count());

        // Assert the count of tokens for the first client
        $this->assertEquals(2, $result->first()->count());

        // Assert the count of tokens for the last client
        $this->assertEquals(1, $result->last()->count());
    }

    /**
     * Test the "getActiveByClientId" method.
     */
    public function test_get_active_by_client_id(): void
    {
        // Create the token repository instance
        $repository = $this->app->make(TokenRepository::class);

        // Create a user
        $user = User::factory()->create();

        // Create two client instances
        $clientOne = Factory::factoryForModel(Client::class)->create();
        $clientTwo = Factory::factoryForModel(Client::class)->create();

        // Create four tokens for clientOne
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 1',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ])->refresh();
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 3 (revoked)',
            'revoked' => true,
            'expires_at' => now()->addDay(),
        ]);
        $clientOne->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 1 Token 4 (expired)',
            'revoked' => true,
            'expires_at' => now()->addDay(),
        ]);

        // Create a token for clientTwo
        $clientTwo->tokens()->create([
            'id' => Str::random(100),
            'user_id' => $user->id,
            'name' => 'Client 2 Token',
            'revoked' => false,
            'expires_at' => now()->addDay(),
        ]);

        // Call the getActiveByClientId method
        $result = $repository->getActiveByClientId($clientOne->id);

        // Assert the expected result count
        $this->assertEquals(1, $result->count());
    }
}
