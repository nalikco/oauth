<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthenticateService;
use Illuminate\Http\RedirectResponse;

class SignOutController extends Controller
{
    public function __construct(
        private readonly AuthenticateService $service,
    ) {
    }

    /**
     * Handles the request to sign out the user.
     *
     * @return RedirectResponse The redirect response to the sign-in route.
     */
    public function handle(): RedirectResponse
    {
        // Sign out the user
        $this->service->signOut();

        // Redirect to the sign-in route
        return redirect()->route('sign-in');
    }
}
