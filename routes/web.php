<?php

use Livewire\Volt\Volt;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('livewire.auth.login');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboards');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/harvesting', function () {
    return view('harvesting');
})->middleware(['auth', 'verified'])->name('harvesting');

Route::get('/quality', function () {
    return view('quality');
})->middleware(['auth', 'verified'])->name('quality');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
