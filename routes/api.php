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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
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