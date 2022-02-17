<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt.auth')->get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::middleware('api')->group(function () {
            Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
            Route::middleware('jwt.auth')->group(function () {
                Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
            });
        });
        Route::post('create', [App\Http\Controllers\AuthController::class, 'create'])->name('user.create');
    });
    Route::get('category/{uuid}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
});
