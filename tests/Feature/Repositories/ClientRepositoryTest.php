<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Dto\Client\StoreDto;
use App\Dto\Client\UpdateDto;
use App\Models\Passport\Client;
use App\Models\User;
use App\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the "getWithPaginate" method of the ClientRepository class.
     */
    public function test_get_with_paginate(): void
    {
        // Instantiate the client repository
        $repository = $this->app->make(ClientRepository::class);

        // Create a new client
        $client = Factory::factoryForModel(Client::class)->create();

        // Call the getWithPaginate method of the repository and get the result
        $result = $repository->getWithPaginate(1, 15);

        // Assert that the returned client has the correct values
        $this->assertEquals([$client->fresh()], $result->items());

        // Assert that the returned client has the correct pagination
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals(15, $result->perPage());
    }

    /**
     * Test the store method of the ClientRepository class.
     * @throws \JsonException
     */
    public function test_store(): void
    {
        // Get the current locale
        $locale = $this->app->getLocale();

        // Create an instance of the ClientRepository class
        $repository = $this->app->make(ClientRepository::class);

        // Create a new user
        $user = User::factory()->create();

        // Create a new StoreDto instance with the necessary data
        $dto = new StoreDto(
            name: [$locale => 'Test Client'],
            brand: [$locale => 'Test Brand'],
            description: [$locale => 'Test Description'],
            redirect: 'https://example.com/oauth/callback',
            link: 'https://example.com',
        );

        // Call the store method of the ClientRepository class to store a new client
        $client = $repository->store($user->id, $dto);

        // Assert that the returned client instance is of the Client class
        $this->assertInstanceOf(Client::class, $client);

        // Assert that there is only 1 record in the oauth_clients table
        $this->assertEquals(1, Client::query()->count());

        // Assert that the necessary data is stored in the oauth_clients table
        $this->assertDatabaseHas('oauth_clients', [
            'user_id' => $user->id,
            'name' => $dto->name[$locale],
            'name_translated' => json_encode($dto->name, JSON_THROW_ON_ERROR),
            'brand' => json_encode($dto->brand, JSON_THROW_ON_ERROR),
            'description' => json_encode($dto->description, JSON_THROW_ON_ERROR),
            'link' => $dto->link,
            'redirect' => $dto->redirect,
        ]);

        // Assert that the client instance has the correct values
        $this->assertEquals($user->id, $client->user_id);
        $this->assertEquals($dto->name[$locale], $client->name);
        $this->assertEquals($dto->name, $client->name_translated);
        $this->assertEquals($dto->brand, $client->brand);
        $this->assertEquals($dto->description, $client->description);
        $this->assertEquals($dto->link, $client->link);
        $this->assertEquals($dto->redirect, $client->redirect);
    }

    /**
     * Test the update method of the repository.
     */
    public function test_update(): void
    {
        // Get the current locale
        $locale = $this->app->getLocale();

        // Create an instance of the ClientRepository
        $repository = $this->app->make(ClientRepository::class);

        // Create a new client
        /** @var Client $client */
        $client = Factory::factoryForModel(Client::class)->create();

        // Create a new StoreDto with updated values
        $dto = new UpdateDto(
            name: [$locale => 'Updated Client'],
            brand: [$locale => 'Updated Brand'],
            description: [$locale => 'Updated Description'],
            redirect: 'https://updated-example.com/oauth/callback',
            link: 'https://updated-example.com',
            image: 'updated-test.jpg',
        );

        // Update the client using the repository
        $updatedClient = $repository->update($client, $dto);

        // Assert that the updated client is an instance of the Client class
        $this->assertInstanceOf(Client::class, $updatedClient);

        // Assert that the updated client's data is stored correctly in the database
        $this->assertDatabaseHas('oauth_clients', [
            'id' => $client->id,
            'name' => $dto->name[$locale],
            'name_translated' => json_encode($dto->name, JSON_THROW_ON_ERROR),
            'brand' => json_encode($dto->brand, JSON_THROW_ON_ERROR),
            'description' => json_encode($dto->description, JSON_THROW_ON_ERROR),
            'link' => $dto->link,
            'redirect' => $dto->redirect,
            'image' => $dto->image,
        ]);

        // Assert that the updated client's properties have the expected values
        $this->assertEquals($dto->name[$locale], $updatedClient->name);
        $this->assertEquals($dto->name, $updatedClient->name_translated);
        $this->assertEquals($dto->brand, $updatedClient->brand);
        $this->assertEquals($dto->description, $updatedClient->description);
        $this->assertEquals($dto->link, $updatedClient->link);
        $this->assertEquals($dto->redirect, $updatedClient->redirect);
        $this->assertEquals($dto->image, $updatedClient->image);
    }

    /**
     * Test case for updating the image field of a client.
     */
    public function test_update_image_field(): void
    {
        // Instantiate the client repository
        $repository = $this->app->make(ClientRepository::class);

        // Create a new client
        /** @var Client $client */
        $client = Factory::factoryForModel(Client::class)->create();

        // Update the image field of the client
        $updatedClient = $repository->updateImageField($client, 'updated-test.jpg');

        // Assert that the returned client is an instance of the Client class
        $this->assertInstanceOf(Client::class, $updatedClient);

        // Assert that the image field of the updated client matches the updated image
        $this->assertEquals('updated-test.jpg', $updatedClient->image);

        // Assert that the database contains the updated image for the client
        $this->assertDatabaseHas('oauth_clients', [
            'id' => $client->id,
            'image' => 'updated-test.jpg',
        ]);
    }

    /**
     * Test the destroy method of the repository.
     */
    public function test_destroy(): void
    {
        // Instantiate the client repository
        $repository = $this->app->make(ClientRepository::class);

        // Create a new client using the factory
        $client = Factory::factoryForModel(Client::class)->create();

        // Call the destroy method on the repository
        $repository->destroy($client);

        // Assert that the count of clients is 0
        $this->assertEquals(0, Client::query()->count());
    }
}
