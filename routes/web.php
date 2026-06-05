<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Rute untuk Halaman Utama & Kelola
Route::get('/', [AuthController::class, 'index']);
Route::get('/kelola', [AuthController::class, 'kelola']);

// Rute untuk Autentikasi (Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Rute untuk Produk (Admin Only)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Rute untuk Pesanan
Route::get('/orders', [OrderController::class, 'index']);           // Admin: daftar pesanan
Route::get('/order', [OrderController::class, 'create']);           // Customer: form pesanan
Route::post('/orders', [OrderController::class, 'store']);          // Customer: submit pesanan
Route::get('/orders/{id}', [OrderController::class, 'show']);       // Detail pesanan
Route::get('/orders/{id}/edit', [OrderController::class, 'edit']);  // Admin: edit status
Route::put('/orders/{id}', [OrderController::class, 'update']);     // Admin: update status
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Admin: hapus pesanan

