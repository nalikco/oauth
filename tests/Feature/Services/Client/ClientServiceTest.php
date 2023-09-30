<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Client;

use App\Dto\Client\CreateDto;
use App\Dto\Client\StoreDto;
use App\Dto\Client\UpdateDto;
use App\Models\Passport\Client;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Services\Client\ClientService;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    /**
     * Test the store method of the ClientService class.
     */
    public function test_store(): void
    {
        // Get the current locale
        $locale = $this->app->getLocale();

        // Create a new User instance
        $user = new User();
        $user->id = 1;

        // Create a fake image file
        $image = UploadedFile::fake()->image('test.jpg', 100, 100);

        // Create a new CreateDto instance with test data
        $dto = new CreateDto(
            name: [$locale => 'Test Client'],
            brand: [$locale => 'Test Brand'],
            description: [$locale => 'Test Description'],
            redirect: 'https://example.com/oauth/callback',
            link: 'https://example.com',
            image: $image,
        );

        // Create a fake Client instance
        $fakeClient = new Client();
        $fakeClient->id = 1;

        // Mock the ClientRepository store method
        $this->mock(ClientRepository::class, function (MockInterface $mock) use ($user, $fakeClient) {
            $mock->shouldReceive('store')
                ->with($user->id, StoreDto::class)
                ->once()
                ->andReturn($fakeClient);
            $mock->shouldReceive('updateImageField')
                ->with($fakeClient, 'clients/1-test.jpg')
                ->andReturn($fakeClient);
        });

        // Mock the ImageService store method
        $this->mock(ImageService::class, function (MockInterface $mock) use ($image) {
            $mock->shouldReceive('store')
                ->with('clients', 1, $image)
                ->once()
                ->andReturn('clients/1-test.jpg');
        });

        // Create a new instance of the ClientService class
        $service = $this->app->make(ClientService::class);

        // Assert that the store method returns the expected result
        $this->assertEquals($fakeClient, $service->store($user, $dto));
    }

    /**
     * Test the update method of the ClientService class.
     */
    public function test_update(): void
    {
        // Get the current locale
        $locale = $this->app->getLocale();

        // Create a fake image file
        $image = UploadedFile::fake()->image('updated-test.jpg', 100, 100);

        // Create a new CreateDto object with updated values
        $dto = new CreateDto(
            name: [$locale => 'Updated Client'],
            brand: [$locale => 'Updated Brand'],
            description: [$locale => 'Updated Description'],
            redirect: 'https://updated-example.com/oauth/callback',
            link: 'https://updated-example.com',
            image: $image,
        );

        // Create a fake client object with id 1
        $fakeClient = new Client();
        $fakeClient->id = 1;

        // Mock the update method of the ClientRepository class to return the fake client
        $this->mock(ClientRepository::class, function (MockInterface $mock) use ($fakeClient) {
            $mock->shouldReceive('update')
                ->with($fakeClient, UpdateDto::class)
                ->once()
                ->andReturn($fakeClient);
        });

        // Mock the store method of the ImageService class to return the image path
        $this->mock(ImageService::class, function (MockInterface $mock) use ($image) {
            $mock->shouldReceive('store')
                ->with('clients', 1, $image)
                ->once()
                ->andReturn('clients/1-updated-test.jpg');
        });

        // Get an instance of the ClientService class
        $service = $this->app->make(ClientService::class);

        // Assert that the update method returns the fake client
        $this->assertEquals($fakeClient, $service->update($fakeClient, $dto));
    }

    /**
     * Test the destroy method of the ClientService class.
     */
    public function test_destroy(): void
    {
        // Create a fake client object with an id of 1
        $fakeClient = new Client();
        $fakeClient->id = 1;

        // Mock the destroy method of the ClientRepository class
        $this->mock(ClientRepository::class, function (MockInterface $mock) use ($fakeClient) {
            // Expect the destroy method to be called with the fake client object
            $mock->shouldReceive('destroy')
                ->with($fakeClient)
                ->once();
        });

        // Create an instance of the ClientService class
        $service = $this->app->make(ClientService::class);

        // Call the destroy method of the ClientService class with the fake client object
        $service->destroy($fakeClient);
    }
}
