<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class Recovery extends Controller
{
    function show(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.recovery');
        }
        return view('customer.authentication.recovery');
    }

    function sendResetLink(Request $request)
    {
        session()->flash('email', $request->email);
        $request->validate(['email' => 'required|email']);

        $validator = Validator::make($request->all(), []);

        $user = User::where('email', $request->email)->first();
        if ((!$user || $user->is_admin) && $request->user_type == 'customer') {
            $validator->errors()->add('email', 'We can\'t find a user with that email address.');
            return back()->withErrors($validator->errors());
        } else if ((!$user || !$user->is_admin) && $request->user_type == 'admin') {
            $validator->errors()->add('email', 'We can\'t find an admin with that email address.');
            return back()->withErrors($validator->errors());
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    function resetShow()
    {
    }
}
