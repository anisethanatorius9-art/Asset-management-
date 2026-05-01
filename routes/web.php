<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/home', function () {
    return view('home');
})->name('home1');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('assets', 'assets.index')->name('assets');
    Volt::route('system-logs', 'navigation.system-logs')->name('system-logs');

    Route::prefix('config')->name('config.')->group(function () {
        Volt::route('locations', 'configs.location')->name('locations');
    });
    Route::prefix('config')->name('config.')->group(function () {
        Volt::route('categories', 'configs.category')->name('categories');
    });

});


require __DIR__ . '/auth.php';
