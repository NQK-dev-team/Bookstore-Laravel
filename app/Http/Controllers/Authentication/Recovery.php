<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class Recovery extends Controller
{
    function adminShow()
    {
        return view('admin.authentication.recovery');
    }

    function customerShow()
    {
        return view('customer.authentication.recovery');
    }

    function sendResetLink(Request $request)
    {
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status === Password::RESET_LINK_SENT
        //     ? back()->with(['status' => __($status)])
        //     : back()->withErrors(['email' => __($status)]);
    }
}
