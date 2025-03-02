<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas protegidas (autenticadas)
Route::resource('products', ProductController::class)->only(['store', 'update', 'destroy'])->middleware('auth:sanctum');
Route::resource('categories', CategoryController::class)->only(['store', 'update', 'destroy'])->middleware('auth:sanctum');

// Rotas públicas (não autenticadas)
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// Rotas de autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');