<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Run the database seed command
        $this->artisan('db:seed');
    }

    /**
     * Test setting user status as admin.
     */
    public function test_set_user_status_as_admin(): void
    {
        // Instantiate the AdminService class.
        $service = $this->app->make(AdminService::class);

        // Create a new user using the User factory.
        $user = User::factory()->create();

        // Assert that the user does not have the 'admin' role.
        $this->assertFalse($user->hasRole('admin'));

        // Call the setUserStatus method of the AdminService class to set the user status as admin.
        $service->setUserStatus($user, true);

        // Assert that the user now has the 'admin' role.
        $this->assertTrue($user->hasRole('admin'));
    }

    /**
     * Test case to verify that the user status can be set as not admin.
     */
    public function test_set_user_status_as_not_admin(): void
    {
        // Instantiate the AdminService class using the IoC container.
        $service = $this->app->make(AdminService::class);

        // Create a new user using the User factory.
        $user = User::factory()->create();

        // Set the user status as admin using the AdminService.
        $service->setUserStatus($user, true);

        // Set the user status as not admin using the AdminService.
        $service->setUserStatus($user, false);

        // Assert that the user does not have the 'admin' role.
        $this->assertFalse($user->hasRole('admin'));
    }
}
