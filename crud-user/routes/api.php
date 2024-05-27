<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('admin/users', [UserController::class, 'index']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('me', [UserController::class, 'me']);
        Route::post('create', [UserController::class, 'create']);
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'delete']);
    });
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('me', [UserController::class, 'index']);
    });
});
