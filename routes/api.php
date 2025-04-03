<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Engineer\ProjectController;
use App\Http\Controllers\AbscisaController;
use App\Http\Controllers\SlabsController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PathologiesController;
use App\Http\Controllers\Web\WebController;

///// -- API ROUTES FOR MOBIL -- /////
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');
Route::post('model', [ModelController::class, 'ia_model'])->middleware('auth:sanctum');

Route::prefix('project')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/create', [ProjectController::class, 'create']);
    Route::post('/show/detail', [ProjectController::class, 'showDetails']);
});

Route::prefix('abscisa')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AbscisaController::class, 'index']);
    Route::post('/create', [AbscisaController::class, 'create']);
    Route::delete('/delete', [AbscisaController::class, 'delete']);
});

Route::prefix('slab')->middleware('auth:sanctum')->group(function () {
    Route::get('/{abscisa_id}', [SlabsController::class, 'index']);
    Route::post('/create', [SlabsController::class, 'create']);
});

Route::prefix('pathologie')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PathologiesController::class, 'index']);
    Route::post('/create', [PathologiesController::class, 'create']);
    Route::get('/show/concept', [PathologiesController::class, 'showConcept']);
});


// Habilitar la ruta para crear conceptos técnicos de patologías
// Route::post('/create-concept', [PathologiesController::class, 'createNewPathologyConcept']);

///// -- API ROUTES FOR WEB -- /////
Route::prefix('web')->middleware('auth:sanctum')->group(function () {
    Route::get('/projects/index', [WebController::class, 'index']);
    Route::post('/projects/show', [WebController::class, 'getDetails']);
});