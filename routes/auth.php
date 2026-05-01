<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');

    Route::get('login/google', function () {
        return redirect()->away('https://accounts.google.com/signin');
    })->name('login.google');

    Route::get('login/whatsapp', function () {
        $number = config('services.whatsapp.number', '255700000000');
        $message = rawurlencode(config('services.whatsapp.message', 'Hello%20I%20need%20help%20logging%20in%20to%20Asset%20Management.'));

        return redirect()->away("https://wa.me/{$number}?text={$message}");
    })->name('login.whatsapp');

});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
