<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\DeleteAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class Logout extends Controller
{
    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.authentication.index');
    }

    public function customerLogout(Request $request): RedirectResponse
    {
        if ($request->is_delete_account_request) {
            DB::table('delete_queue')->insert([
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')),
                'updated_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')),
            ]);
            Mail::to(Auth::user()->email)->queue(new DeleteAccount(Auth::user()->name));
        }

        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('customer.home.index');
    }
}
