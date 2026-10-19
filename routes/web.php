
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;

Route::get('/', [StoreController::class, 'index'])->name('store.home');

Route::get('/store', [StoreController::class, 'index'])->name('store');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store');

Route::post('/coupons/validate', [StoreController::class, 'validateCoupon'])
    ->name('coupons.validate');
