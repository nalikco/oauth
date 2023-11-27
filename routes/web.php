<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\PasswordReset\ResetController;
use App\Http\Controllers\Auth\PasswordReset\SendLinkController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', (new HomeController())->view(...))
    ->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/sign-in', [SignInController::class, 'view'])
        ->name('sign-in');
    Route::post('/sign-in', [SignInController::class, 'handle'])
        ->name('sign-in.handle');

    Route::get('/sign-up', [SignUpController::class, 'view'])
        ->name('sign-up');
    Route::post('/sign-up', [SignUpController::class, 'handle'])
        ->name('sign-up.handle');

    Route::get('/password-reset', [SendLinkController::class, 'view'])
        ->name('password.send-link');
    Route::post('/password-reset', [SendLinkController::class, 'handle'])
        ->name('password.send-link.handle');

    Route::get('/password-reset/reset', [ResetController::class, 'view'])
        ->name('password.reset');
    Route::post('/password-reset/reset', [ResetController::class, 'handle'])
        ->name('password.reset.handle');
});

Route::middleware('auth')->group(function () {
    Route::get('/sign-out', [SignOutController::class, 'handle'])
        ->name('sign-out');

    Route::get('/dashboard', [DashboardController::class, 'view'])
        ->name('dashboard');
});

Route::resource('clients', ClientController::class)
    ->middleware(['auth', 'admin']);
