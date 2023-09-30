<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Dto\User\StoreDto;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the success case of finding a user by ID or fail.
     */
    public function test_find_by_id_or_fail_success(): void
    {
        // Create an instance of the UserRepository
        $repository = $this->app->make(UserRepository::class);

        // Create a new user using the factory
        $user = User::factory()->create();

        // Assert that the user found using the query builder is equal to the user found using the repository
        $this->assertEquals(
            User::query()->find($user->id),
            $repository->findByIdOrFail($user->id),
        );
    }

    /**
     * Test case for when findByIdOrFail() fails to find a user.
     */
    public function test_find_by_id_or_fail_failed(): void
    {
        // Instantiate the UserRepository using the IoC container
        $repository = $this->app->make(UserRepository::class);

        // Expect a ModelNotFoundException to be thrown
        $this->expectException(ModelNotFoundException::class);

        // Call the findByIdOrFail() method with an invalid ID
        $repository->findByIdOrFail(0);
    }

    /**
     * Test for the findByEmail method of the UserRepository class.
     */
    public function test_find_by_email(): void
    {
        // Instantiate the UserRepository class using the app container.
        $repository = $this->app->make(UserRepository::class);

        // Create a new user.
        $user = User::factory()->create();

        // Define an array of test cases.
        $testCases = [
            [
                'email' => $user->email,
                'expected' => User::query()->find($user->id),
            ],
            [
                'email' => 'wrong',
                'expected' => null,
            ],
        ];

        // Iterate through each test case and run the assertions.
        foreach ($testCases as $case) {
            $this->assertEquals($case['expected'], $repository->findByEmail($case['email']));
        }
    }

    /**
     * Test the 'store' method of the UserRepository.
     */
    public function test_store(): void
    {
        // Instantiate the UserRepository
        $repository = $this->app->make(UserRepository::class);

        // Create a new user using the 'store' method of the UserRepository
        $user = $repository->store(new StoreDto(
            name: 'Name',
            email: 'test@mail.com',
            password: 'password'
        ));

        // Assert that the user's password is correctly hashed
        $this->assertTrue(Hash::check('password', $user->password));

        // Assert that there is only one user in the database
        $this->assertEquals(1, User::query()->count());

        // Assert that the user is stored in the database with the correct name and email
        $this->assertDatabaseHas('users', [
            'name' => 'Name',
            'email' => 'test@mail.com',
        ]);
    }
}
