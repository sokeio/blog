<?php

use Illuminate\Support\Facades\Route;
use SokeioTheme\Blog\Livewire\Auth\ForgotPassword;
use SokeioTheme\Blog\Livewire\Auth\Login;
use SokeioTheme\Blog\Livewire\Auth\Signup;

Route::name('site.')->group(function () {
    permalinkRoute('site_login_ permalink', 'login', Login::class, 'login');
    permalinkRoute('site_logout_ permalink', 'logout', function () {
        auth()->logout();
        return redirect(route('site.login'));
    }, 'logout');
    permalinkRoute('site_sign_up_ permalink', 'sign-up', Signup::class, 'sign-up');
    permalinkRoute('site_forgot_password_ permalink', 'forgot-password', ForgotPassword::class, 'forgot-password');
});
