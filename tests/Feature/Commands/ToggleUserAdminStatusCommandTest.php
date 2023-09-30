<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleUserAdminStatusCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Run the database seed command
        $this->artisan('db:seed');
    }

    /**
     * Test for setting a user as admin.
     */
    public function test_successful_set_user_as_admin(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Assert that the user does not have the 'admin' role
        $this->assertFalse($user->hasRole('admin'));

        // Run the 'admins:toggle' artisan command and provide input
        $this->artisan('admins:toggle')
            ->expectsQuestion('Enter User ID', $user->id)
            ->expectsQuestion('Choice User Status', 'Admin')
            ->expectsOutput("New User $user->email status: Admin")
            ->assertExitCode(0);

        // Assert that the user now has the 'admin' role
        $this->assertTrue(User::query()->find($user->id)->hasRole('admin'));
    }

    /**
     * Test case to set a user as not admin.
     */
    public function test_successful_set_user_as_not_admin(): void
    {
        // Create a new user using the User factory
        $user = User::factory()->create();

        // Assign the 'admin' role to the user
        $user->assignRole('admin');

        // Run the 'admins:toggle' artisan command and provide user input
        $this->artisan('admins:toggle')
            ->expectsQuestion('Enter User ID', $user->id)
            ->expectsQuestion('Choice User Status', 'Not Admin')
            ->expectsOutput("New User $user->email status: Not Admin")
            ->assertExitCode(0);

        // Verify that the user no longer has the 'admin' role
        $this->assertFalse(User::query()->find($user->id)->hasRole('admin'));
    }
}
