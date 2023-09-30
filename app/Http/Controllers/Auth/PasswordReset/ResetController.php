<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\PasswordReset;

use App\Enums\FlashMessageType;
use App\Exceptions\Auth\PasswordReset\PasswordResetException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordReset\ResetRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ResetController extends Controller
{
    public function __construct(
        private readonly PasswordResetService $service,
    ) {
    }

    public function view(): View
    {
        return view('pages.password-reset.reset', [
            'title' => __('auth.password_reset.send_link.title'),
        ]);
    }

    /**
     * Handle the reset request.
     *
     * @param  ResetRequest  $request The request object.
     */
    public function handle(ResetRequest $request): RedirectResponse
    {
        // Try to reset the password
        try {
            $this->service->reset(
                $request->validated('token'),
                $request->validated('email'),
                $request->validated('password')
            );

            // Redirect back with success message
            return redirect()->route('sign-in')->with([
                FlashMessageType::Success->value => __('passwords.reset'),
            ]);
        } catch (PasswordResetException $e) {
            // If an exception is thrown, redirect back with error message
            return redirect()->back()->withErrors(['token' => $e->getMessage()]);
        }
    }
}
