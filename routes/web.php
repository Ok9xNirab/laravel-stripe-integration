<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'page'])->name('products');
Route::post('/buy-product', [ProductController::class, 'buyProduct']);
Route::get('/checkout/success', [ProductController::class, 'thankYou']);
