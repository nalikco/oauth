<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Services\Auth\AuthenticateService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SignInController extends Controller
{
    public function __construct(
        private readonly AuthenticateService $service,
    ) {
    }

    /**
     * Generates a view for the login page.
     *
     * @return View A view object representing the login page.
     */
    public function view(): View
    {
        return view('pages.auth.sign-in', [
            'title' => __('auth.sign_in.title'),
        ]);
    }

    /**
     * Handle the sign-in request.
     */
    public function handle(SignInRequest $request): RedirectResponse
    {
        try {
            // Authenticate the user via credentials
            $this->service->authenticateViaCredentials(
                $request->validated('email'),
                $request->validated('password'),
            );

            // Redirect to the dashboard
            return redirect()->route('dashboard');
        } catch (UnauthorizedException) {
            // If authentication fails, redirect back with error message and email input
            return back()->withInput(['email' => $request->validated('email')])->withErrors([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
