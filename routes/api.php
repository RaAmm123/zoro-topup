<?php
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
Route::get('/packages', [StoreController::class, 'packages']);
Route::post('/coupons/validate', [StoreController::class, 'validateCoupon'])->middleware('throttle:20,1');
Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:10,1');
Route::get('/orders/{order_number}', [OrderController::class, 'status']);
