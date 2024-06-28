<?php

use Illuminate\Routing\RouteAction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return '/';
    })->name('index');

    Route::get('authentication', function () {
        return 'authentication';
    })->name('authentication');

    Route::prefix('manage')->name('manage.')->group(function () {
        Route::get('book', function () {
            return 'manage/book';
        })->name('book');

        Route::get('category', function () {
            return 'manage/category';
        })->name('category');

        Route::get('customer', function () {
            return 'manage/customer';
        })->name('customer');

        Route::get('coupon', function () {
            return 'manage/coupon';
        })->name('coupon');

        Route::get('request', function () {
            return 'manage/request';
        })->name('request');
    });
});


// Customer routes

// General routes
Route::get('about-us', function () {
    return 'about us';
})->name('about-us');

Route::get('discount-program', function () {
    return 'discount-program';
})->name('discount-program');

Route::get('privacy-policy', function () {
    return 'privacy policy';
})->name('privacy-policy');

Route::get('terms-of-service', function () {
    return 'terms-of-service';
})->name('terms-of-service');
