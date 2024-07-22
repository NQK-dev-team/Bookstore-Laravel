<?php

namespace App\Http\Controllers\Authentication;

use App\Mail\CancelDelete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        if (DB::table('delete_queue')->where([['user_id', '=', Auth::user()->id],])->exists()) {
            DB::table('delete_queue')->where([['user_id', '=', Auth::user()->id],])->delete();
            Mail::to(Auth::user()->email)->queue(new CancelDelete(Auth::user()->name));
        }

        $user = User::find(Auth::user()->id);
        $paypalToken = $user->createToken('paypal_token', ['*'], now()->addDays(3));
        return redirect()->route('customer.index')->withCookie(cookie('paypal_token', $paypalToken->plainTextToken, 0, null, null, null, false, false, 'Lax'));
    }

    public function show(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.index');
        }
        return view('customer.authentication.index');
    }
}
