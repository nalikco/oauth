<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\Auth\PasswordReset\PasswordResetException;
use App\Exceptions\Auth\PasswordReset\PasswordResetLinkNotSentException;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

readonly class PasswordResetService
{
    /**
     * Sends a password reset link to the specified email address.
     *
     * @param  string  $email The email address to send the reset link to.
     *
     * @throws PasswordResetLinkNotSentException If the reset link is not sent successfully.
     */
    public function sendLink(string $email): void
    {
        // Send the reset link using the Password class
        $status = Password::sendResetLink([
            'email' => $email,
        ]);

        // Check if the reset link was sent successfully
        if ($status != Password::RESET_LINK_SENT) {
            // If not, throw an exception with the status message
            throw new PasswordResetLinkNotSentException(__($status));
        }
    }

    /**
     * Reset the password for a user.
     *
     * @param  string  $token The password reset token.
     * @param  string  $email The user's email address.
     * @param  string  $password The new password.
     *
     * @throws PasswordResetException If the password reset fails.
     */
    public function reset(string $token, string $email, string $password): void
    {
        // Reset the password using the given token, email, and password
        $status = Password::reset(
            [
                'token' => $token,
                'email' => $email,
                'password' => $password,
            ],
            function (User $user, string $password) {
                // Update the user's password
                $user->update([
                    'password' => $password,
                ]);

                // Trigger the PasswordReset event
                event(new PasswordReset($user));
            }
        );

        // If the password reset was not successful, throw an exception
        if ($status != Password::PASSWORD_RESET) {
            throw new PasswordResetException(__($status));
        }
    }
}
