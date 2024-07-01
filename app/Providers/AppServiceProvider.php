<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function (User $user) {
            return $user->is_admin == 1;
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            if ($user->is_admin) {
                return route('admin.authentication.password.reset', ['token' => $token, 'email' => Crypt::encryptString($user->email)]);
            }
            return route('customer.authentication.password.reset', ['token' => $token, 'email' => Crypt::encryptString($user->email)]);
        });
    }
}
