<?php

use App\Http\Controllers\Customer\Cart\CartController;
use Illuminate\Support\Facades\Route;

Route::post('/create-paypal-order', [CartController::class, 'createPaypalOrder']);
Route::post('/capture-paypal-order/{id}', [CartController::class, 'capturePaypalOrder']);
