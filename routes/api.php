<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('guest')->group(function () {
//     Route::get('register', [RegisteredUserController::class, 'create'])
//                 ->name('register');

//     Route::post('register', [RegisteredUserController::class, 'store']);

//     Route::get('login', [AuthenticatedSessionController::class, 'create'])
//                 ->name('login');

//     Route::post('login', [AuthenticatedSessionController::class, 'store']);

//     Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//                 ->name('password.request');

//     Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//                 ->name('password.email');

//     Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//                 ->name('password.reset');

//     Route::post('reset-password', [NewPasswordController::class, 'store'])
//                 ->name('password.store');
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::get('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create']);
    Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
});

Route::group(['namespace' => 'Post', 'middleware' => 'jwt.auth'], function() {
    Route::get('/posts', [App\Http\Controllers\PostController::class, 'index']);
    Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create']);
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'store']);
    Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show']);
    Route::get('/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit']);
    Route::patch('/posts/{post}', [App\Http\Controllers\PostController::class, 'update']);
    Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy']);
});