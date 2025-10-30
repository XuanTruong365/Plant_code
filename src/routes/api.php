<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
    });

    // User Management Routes
    Route::apiResource('users', UserController::class);

    Route::patch('users/{id}/restore', [UserController::class, 'restore']);
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);
});


