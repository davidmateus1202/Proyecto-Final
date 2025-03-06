<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Engineer\ProjectController;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');

Route::prefix('project')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/create', [ProjectController::class, 'create']);
});