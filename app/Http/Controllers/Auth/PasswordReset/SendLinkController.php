<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\PasswordReset;

use App\Enums\FlashMessageType;
use App\Exceptions\Auth\PasswordReset\PasswordResetLinkNotSentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordReset\SendLinkRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SendLinkController extends Controller
{
    public function __construct(
        private readonly PasswordResetService $service,
    ) {
    }

    public function view(): View
    {
        return view('pages.password-reset.send-link', [
            'title' => __('auth.password_reset.send_link.title'),
        ]);
    }

    /**
     * Handle the request to send a link.
     *
     * @param  SendLinkRequest  $request The request data.
     * @return RedirectResponse The redirect response.
     */
    public function handle(SendLinkRequest $request): RedirectResponse
    {
        try {
            // Send the link using the validated email
            $this->service->sendLink($request->validated('email'));

            // Redirect back with success message
            return redirect()->back()->with([
                FlashMessageType::Success->value => __('passwords.sent'),
            ]);
        } catch (PasswordResetLinkNotSentException $e) {
            // Redirect back with error message if link sending fails
            return redirect()->back()->withErrors(['email' => $e->getMessage()]);
        }
    }
}
