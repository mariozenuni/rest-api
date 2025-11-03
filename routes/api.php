<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Todo\TodosController;
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('me', [AuthController::class, 'getMe']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('todos', [TodosController::class,'getAll']);
    Route::get('todos/{id}',[TodosController::class,'getById']);
    Route::post('todos', [TodosController::class,'createTodos']);
    Route::put('todos/{id}', [TodosController::class,'updateTodos']);
    Route::delete('todos/{id}', [TodosController::class,'deleteTodos']);
});
