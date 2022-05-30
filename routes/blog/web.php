<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'posts', 'as' => 'blog.'], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('create', 'PostController@create')
            ->name('post:create');
        Route::post('create', 'PostController@create')
            ->name('post:create');
        Route::get('edit/{slug}', 'PostController@edit')
            ->name('post:edit');
        Route::post('edit/{slug}', 'PostController@edit')
            ->name('post:edit');
        Route::get('delete/{id}', 'PostController@delete')
            ->name('post:delete');
    });
    Route::get('{slug}/', 'PostController@details')->where('slug', '[A-Za-z0-9-_]+')
        ->name('post:details');
    Route::get('by/author/{author_id}', 'PostController@getByAuthor')->where('$author_id', '[0-9]+')
        ->name('post:by_author');
});
