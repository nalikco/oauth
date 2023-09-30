<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'sign_out_action' => 'Sign out',
    'sign_in_action' => 'Sign in',
    'sign_in' => [
        'title' => 'Sign in',
        'forgot_password' => 'Forgot your password?',
    ],
    'sign_up_action' => 'Sign up',
    'sign_up' => [
        'title' => 'Sign up',
        'fields' => [
            'name' => 'Your name',
            'email' => 'Your email address',
            'password' => 'Password',
            'password_confirmation' => 'Confirm password',
        ],
    ],

    'password_reset' => [
        'send_link' => [
            'title' => 'Password reset',
            'description' => 'An email with a link to reset your password will be sent to the email address you provided below.',
            'send_link' => 'Send link',
        ],
        'reset' => [
            'description' => 'Create a new password for your account.',
            'update' => 'Update password',
        ],
    ],

    'authorize_app' => [
        'title' => 'Authorization Request',
        'description' => 'is requesting permission to access your account.',
        'scopes_description' => 'This application will be able to:',
        'authorize' => 'Authorize',
        'cancel' => 'Cancel',
    ],
];
