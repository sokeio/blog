<?php

use Illuminate\Support\Facades\Route;

Route::name('site.')->group(function () {
    permalinkRoute('site_login_ permalink', 'login', \SokeioTheme\Tools\Livewire\Auth\Login::class, 'login');
    permalinkRoute('site_logout_ permalink', 'logout', function () {
        auth()->logout();
        return redirect(route('site.login'));
    }, 'logout');
    permalinkRoute('site_sign_up_ permalink', 'sign-up', \SokeioTheme\Tools\Livewire\Auth\Signup::class, 'sign-up');
    permalinkRoute('site_forgot_password_ permalink', 'forgot-password', \SokeioTheme\Tools\Livewire\Auth\ForgotPassword::class, 'forgot-password');
});
