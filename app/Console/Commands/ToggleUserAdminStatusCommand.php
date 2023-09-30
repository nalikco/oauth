<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use App\Services\AdminService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class ToggleUserAdminStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admins:toggle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make/unmake user as admin';

    /**
     * Execute the console command.
     *
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        // Instantiate the UserRepository and AdminService
        $userRepository = app()->make(UserRepository::class);
        $adminService = app()->make(AdminService::class);

        // Get the User ID from user input
        $userId = intval($this->ask('Enter User ID'));

        // Find the user by ID or throw an exception
        $user = $userRepository->findByIdOrFail($userId);

        // Prompt the user to choose the user status
        $status = $this->choice('Choice User Status', ['Admin', 'Not Admin']);

        // Set the user status based on the user's choice
        $adminService->setUserStatus($user, $status == 'Admin');

        // Display the new user status
        $this->line("New User $user->email status: ".($status == 'Admin' ? 'Admin' : 'Not Admin'));
    }
}
