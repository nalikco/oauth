<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\Factories\CreateSignUpDtoFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Services\Auth\AuthenticateService;
use App\Services\Auth\RegisterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SignUpController extends Controller
{
    public function __construct(
        private readonly AuthenticateService $authenticateService,
        private readonly RegisterService $service,
    ) {
    }

    /**
     * Generates a view for the register page.
     *
     * @return View A view object representing the register page.
     */
    public function view(): View
    {
        return view('pages.auth.sign-up', [
            'title' => __('auth.sign_up.title'),
        ]);
    }

    /**
     * Handle the sign-up request.
     */
    public function handle(SignUpRequest $request): RedirectResponse
    {
        // Register the user
        $user = $this->service->register(
            CreateSignUpDtoFactory::createFromRequest($request),
        );

        // Authenticate the user
        $this->authenticateService->authenticate($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }
}
