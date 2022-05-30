<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('App\Http\Controllers\Base\Web')->group(base_path('routes/base/web.php'));
Route::namespace('App\Http\Controllers\Blog\Web')->group(base_path('routes/blog/web.php'));
Route::namespace('App\Http\Controllers\Auth\Web')->group(base_path('routes/auth/web.php'));
