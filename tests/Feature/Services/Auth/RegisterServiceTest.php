<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Auth;

use App\Dto\Auth\SignUpDto;
use App\Services\Auth\RegisterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the register function of the service.
     */
    public function test_register(): void
    {
        // Instantiate the RegisterService class.
        $service = $this->app->make(RegisterService::class);

        // Create a SignUpDto object with the desired data.
        $dto = new SignUpDto(
            name: 'Name', email: 'test@mail.com', password: 'password',
        );

        // Call the register method of the service and get the user object.
        $user = $service->register($dto);

        // Assert that the user's name matches the name in the dto.
        $this->assertEquals($user->name, $dto->name);
        // Assert that the user's email matches the email in the dto.
        $this->assertEquals($user->email, $dto->email);
        // Assert that the user's password is hashed correctly.
        $this->assertTrue(Hash::check($dto->password, $user->password));
    }
}
