<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckCustomerAuth;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Logout;
use App\Http\Controllers\Authentication\Recovery;
use App\Http\Controllers\Authentication\Register;
use App\Http\Middleware\CheckAdminAuth;
use App\Http\Middleware\RedirectAdmin;
use App\Http\Middleware\RedirectCustomer;
use App\Http\Middleware\RedirectVerifiedEmail;
use App\Http\Middleware\VerifyEmail;

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(RedirectCustomer::class)->group(function () {
    Route::prefix('authentication')->name('authentication.')->middleware(RedirectAdmin::class)->group(function () {
        Route::get('/', [Login::class, 'show'])->name('index');
        Route::post('/', [Login::class, 'login'])->name('index');

        Route::get('recovery', [Recovery::class, 'showEmailForm'])->name('recovery');
        Route::post('recovery', [Recovery::class, 'sendResetLink'])->name('recovery');

        Route::get('password-reset', [Recovery::class, 'showNewPasswordForm'])->name('password.reset');
        Route::post('password-reset', [Recovery::class, 'setNewPassword'])->name('password.update');
    });

    Route::middleware(CheckAdminAuth::class)->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('index');

        Route::prefix('manage')->name('manage.')->group(function () {
            Route::prefix('book')->name('book.')->group(function () {
                Route::get('/', function () {
                    return view('admin.manage.book.index');
                })->name('index');
            });

            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', function () {
                    return view('admin.manage.category.index');
                })->name('index');
            });

            Route::prefix('customer')->name('customer.')->group(function () {
                Route::get('/', function () {
                    return view('admin.manage.customer.index');
                })->name('index');
            });

            Route::prefix('coupon')->name('coupon.')->group(function () {
                Route::get('/', function () {
                    return view('admin.manage.coupon.index');
                })->name('index');
            });

            Route::prefix('request')->name('request.')->group(function () {
                Route::get('/', function () {
                    return view('admin.manage.request.index');
                })->name('index');
            });
        });

        Route::prefix('statistic')->name('statistic.')->group(function () {
            Route::get('/', function () {
                return view('admin.statistic.index');
            })->name('index');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', function () {
                return view('admin.profile.index');
            })->name('index');
        });

        Route::post('authentication/logout', [Logout::class, 'adminLogout'])->name('authentication.logout');
    });
});

// Customer routes
Route::prefix('/')->name('customer.')->middleware(RedirectAdmin::class)->group(function () {
    Route::prefix('authentication')->name('authentication.')->middleware(RedirectCustomer::class)->group(function () {
        Route::get('/', [Login::class, 'show'])->name('index');
        Route::post('/', [Login::class, 'login'])->name('index');

        Route::get('recovery', [Recovery::class, 'showEmailForm'])->name('recovery');
        Route::post('recovery', [Recovery::class, 'sendResetLink'])->name('recovery');

        Route::get('register', [Register::class, 'show'])->name('register');
        Route::post('register', [Register::class, 'register'])->name('register');

        Route::get('password-reset', [Recovery::class, 'showNewPasswordForm'])->name('password.reset');
        Route::post('password-reset', [Recovery::class, 'setNewPassword'])->name('password.update');
    });

    Route::prefix('authentication')->name('authentication.')->middleware(RedirectVerifiedEmail::class)->group(function () {
        Route::get('verify-email', [Register::class, 'showVerification'])->name('verify-email');
    });

    Route::middleware(VerifyEmail::class)->group(function () {
        Route::get('/', function () {
            return view('customer.index');
        })->name('index');

        Route::prefix('book')->name('book.')->group(function () {
            Route::get('/', function () {
                return view('customer.book.index');
            })->name('index');
        });

        Route::middleware(CheckCustomerAuth::class)->group(function () {
            Route::prefix('cart')->name('cart.')->group(function () {
                Route::get('/', function () {
                    return view('customer.cart.index');
                })->name('index');
            });

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', function () {
                    return view('customer.profile.index');
                })->name('index');
            });

            Route::post('authentication/logout', [Logout::class, 'customerLogout'])->name('authentication.logout');
        });
    });
});

// General routes
Route::get('about-us', function () {
    return view('general.about-us');
})->name('about-us');

Route::get('discount-program', function () {
    return 'discount-program';
})->name('discount-program');

Route::get('privacy-policy', function () {
    return view('general.privacy-policy');
})->name('privacy-policy');

Route::get('terms-of-service', function () {
    return view('general.terms-of-service');
})->name('terms-of-service');
