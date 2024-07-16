<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            Mail::to(Auth::user()->email)->queue(new DeleteAccount(Auth::user()->name));
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('customer.index');
    }
}
