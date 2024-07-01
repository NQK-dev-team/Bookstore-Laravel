<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Login extends Controller
{
    public function login(Request $request)
    {
        session()->flash('email', $request->email);
        session()->flash('password', $request->password);

        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);

        if (($request->user_type === 'customer' && !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 0]))
            || ($request->user_type === 'admin' && !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1]))
        ) {
            $validator = Validator::make($request->all(), []);
            $validator->errors()->add('error_message', 'Incorrect email or password.');
            return back()->withErrors($validator->errors());
        }

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.index');
        }
        return redirect()->route('customer.index');
    }

    public function show(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.index');
        }
        return view('customer.authentication.index');
    }
}
