<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserGroupController;

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

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']); //ok

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::post('users/{user}/groups/{group}', [UserGroupController::class, 'assign']);
    Route::delete('users/{user}/groups/{group}', [UserGroupController::class, 'remove']);

    Route::get('groups', [GroupController::class, 'index']);
    Route::post('groups', [GroupController::class, 'store']);
    Route::delete('groups/{group}', [GroupController::class, 'destroy']);
});
