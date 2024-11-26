<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/barangs', [BarangController::class, 'index']);
    Route::post('/barangs/post', [BarangController::class, 'store']);
    Route::get('/barangs/show/{id}', [BarangController::class, 'show']);
    Route::put('/barangs/update/{id}', [BarangController::class, 'update']);
    Route::delete('/barangs/delete/{id}', [BarangController::class, 'destroy']);
    
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/kategori/post', [KategoriController::class, 'store']);
    Route::get('/kategori/show/{id}', [KategoriController::class, 'show']);
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy']);
});

