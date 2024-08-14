<?php

use App\Http\Controllers\Admin\Manage\Book;
use App\Http\Controllers\Admin\Manage\Category;
use App\Http\Controllers\Admin\Manage\Coupon;
use App\Http\Controllers\Admin\Manage\Customer;
use App\Http\Controllers\Admin\Manage\Request;
use App\Http\Controllers\Admin\Profile\Profile;
use App\Http\Controllers\Customer\Book\BookController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\VerifyEmail;
use App\Http\Middleware\RedirectAuth;
use App\Http\Middleware\RedirectRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\Login;
use App\Http\Middleware\RedirectVerifiedEmail;
use App\Http\Controllers\Authentication\Logout;
use App\Http\Controllers\Authentication\Recovery;
use App\Http\Controllers\Authentication\Register;
use App\Http\Controllers\Customer\Cart\CartController;
use App\Http\Controllers\Customer\Home\Home as CustomerHome;
use App\Http\Controllers\Customer\Profile\ProfileController;
use App\Http\Controllers\General\File;
use App\Http\Middleware\XssSanitization;
use App\Models\Discount;

Route::middleware(XssSanitization::class)->group(function () {
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(RedirectRole::class)->group(function () {
        Route::prefix('authentication')->name('authentication.')->middleware(RedirectAuth::class)->group(function () {
            Route::get('/', [Login::class, 'show'])->name('index');
            Route::post('/', [Login::class, 'login'])->name('index');

            Route::get('recovery', [Recovery::class, 'showEmailForm'])->name('recovery');
            Route::post('recovery', [Recovery::class, 'sendResetLink'])->name('recovery');

            Route::get('password-reset', [Recovery::class, 'showNewPasswordForm'])->name('password.reset');
            Route::post('password-reset', [Recovery::class, 'setNewPassword'])->name('password.update');
        });

        Route::middleware(CheckAuth::class)->group(function () {
            Route::get('/', function () {
                return view('admin.home.index');
            })->name('home.index');

            Route::prefix('manage')->name('manage.')->group(function () {
                Route::prefix('book')->name('book.')->group(function () {
                    Route::get('/', [Book::class, 'showList'])->name('index');
                    Route::get('/add', [Book::class, 'showAdd'])->name('add');
                    Route::post('/add', [Book::class, 'addBook'])->name('add');
                    Route::get('/{id}', [Book::class, 'showDetail'])->name('detail');
                    Route::post('/{id}', [Book::class, 'updateBook'])->name('update');
                });

                Route::prefix('category')->name('category.')->group(function () {
                    Route::get('/', [Category::class, 'show'])->name('index');
                });

                Route::prefix('customer')->name('customer.')->group(function () {
                    Route::get('/', [Customer::class, 'show'])->name('index');
                });

                Route::prefix('coupon')->name('coupon.')->group(function () {
                    Route::get('/', [Coupon::class, 'show'])->name('index');
                });

                Route::prefix('request')->name('request.')->group(function () {
                    Route::get('/', [Request::class, 'show'])->name('index');
                });
            });

            Route::prefix('statistic')->name('statistic.')->group(function () {
                Route::get('/', function () {
                    return view('admin.statistic.index');
                })->name('index');
            });

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [Profile::class, 'show'])->name('index');
                Route::post('update-profile', [Profile::class, 'updateProfile'])->name('update');
                Route::post('change-password', [Profile::class, 'changePassword'])->name('change-password');
            });

            Route::post('authentication/logout', [Logout::class, 'adminLogout'])->name('authentication.logout');
        });
    });

    // Customer routes
    Route::prefix('/')->name('customer.')->middleware(RedirectRole::class)->group(function () {
        Route::prefix('authentication')->name('authentication.')->middleware(RedirectAuth::class)->group(function () {
            Route::get('/', [Login::class, 'show'])->name('index');
            Route::post('/', [Login::class, 'login'])->name('index');

            Route::get('recovery', [Recovery::class, 'showEmailForm'])->name('recovery');
            Route::post('recovery', [Recovery::class, 'sendResetLink'])->name('recovery');

            Route::get('register', [Register::class, 'show'])->name('register');
            Route::post('register', [Register::class, 'register'])->name('register');

            Route::get('password-reset', [Recovery::class, 'showNewPasswordForm'])->name('password.reset');
            Route::post('password-reset', [Recovery::class, 'setNewPassword'])->name('password.update');
        });

        Route::prefix('authentication')->name('authentication.')->middleware([CheckAuth::class, RedirectVerifiedEmail::class])->group(function () {
            Route::get('verify-email', [Register::class, 'showVerification'])->name('verify-email');
            Route::get('verify-email/{email}/{token}', [Register::class, 'verifyEmail'])->name('verify');
            Route::post('verify-email', [Register::class, 'requestVerification'])->name('verify-email');
        });

        Route::middleware(VerifyEmail::class)->group(function () {
            Route::get('/', [CustomerHome::class, 'show'])->name('home.index');

            Route::prefix('book')->name('book.')->group(function () {
                Route::get('/', [BookController::class, 'showList'])->name('index');

                Route::get('/{id}', [BookController::class, 'showDetail'])->name('detail');
            });

            Route::middleware(CheckAuth::class)->group(function () {
                Route::prefix('cart')->name('cart.')->group(function () {
                    Route::get('/', [CartController::class, 'show'])->name('index');
                });

                Route::prefix('profile')->name('profile.')->group(function () {
                    Route::get('/', [ProfileController::class, 'show'])->name('index');
                    Route::post('update-profile', [ProfileController::class, 'updateProfile'])->name('update');
                    Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
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
        $referrerDiscounts = Discount::whereHas('referrerDiscount')->get();
        $customerDiscounts = Discount::whereHas('customerDiscount')->get();

        return view('general.discount-program', [
            'referrerDiscounts' => $referrerDiscounts,
            'customerDiscounts' => $customerDiscounts,
        ]);
    })->name('discount-program');

    Route::get('privacy-policy', function () {
        return view('general.privacy-policy');
    })->name('privacy-policy');

    Route::get('terms-of-service', function () {
        return view('general.terms-of-service');
    })->name('terms-of-service');

    // Temporary route
    Route::name('temporary-url.')->prefix('temporary-url')->group(function () {
        // Route::get('image', [File::class, 'handleImage'])->where('path', '.*')->name('image');
        // Route::get('pdf', [File::class, 'handlePDF'])->where('path', '.*')->name('pdf');
        Route::get('image/{path}', [File::class, 'handleImage'])->where('path', '.*')->name('image');
        Route::get('pdf/{path}', [File::class, 'handlePDF'])->where('path', '.*')->name('pdf');
    });
});
