<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'base.'], function (){
    Route::get('/', 'HomePageController@show')
        ->name('home');
    Route::get('search', 'SearchController@show')
        ->name('search');
});
