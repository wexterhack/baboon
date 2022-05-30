<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function (){
    Route::get('login', 'LoginController@showLoginForm')
        ->name('login');
    Route::post('login', 'LoginController@login')
        ->name('login');

    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')
        ->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm')
        ->name('password.confirm');

    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
        ->name('password.email');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
        ->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset')
        ->name('password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
        ->name('password.reset');

    Route::get('register', 'RegisterController@showRegistrationForm')
        ->name('register');
    Route::post('register', 'RegisterController@register')
        ->name('register');

    Route::get('logout', 'LoginController@logout')
        ->name('logout');

    Route::get('/{id}/', 'UserController@profile')->where('id', '[0-9]+')
        ->name('user:profile');
});
