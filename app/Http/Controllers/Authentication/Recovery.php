<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Mail\PasswordChange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rules\Password as PasswordRule;

class Recovery extends Controller
{
    function showEmailForm(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.recovery');
        }
        return view('customer.authentication.recovery');
    }

    function sendResetLink(Request $request)
    {
        $email = trim($request->email);
        session()->flash('email', $email);

        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user = User::where('email', $email)->first();
        if ((!$user || $user->is_admin) && $request->user_type === 'customer') {
            $validator->errors()->add('email', 'We can\'t find a user with that email address.');
            return back()->withErrors($validator->errors());
        } else if ((!$user || !$user->is_admin) && $request->user_type === 'admin') {
            $validator->errors()->add('email', 'We can\'t find an admin with that email address.');
            return back()->withErrors($validator->errors());
        }

        $status = Password::sendResetLink(
            ['email' => $email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    function showNewPasswordForm(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.reset-password', ['token' => trim($request->token), 'email' => trim($request->email)]);
        }
        return view('customer.authentication.reset-password', ['token' => trim($request->token), 'email' => trim($request->email)]);
    }

    function setNewPassword(Request $request)
    {
        $token = trim($request->token);
        $email = trim($request->email);
        $password = trim($request->password);
        $confirmPassword = trim($request->confirmPassword);

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'token' => $token,
        ], [
            'token' => 'required',
            'email' => 'required',
            'password' => ['required', 'string', PasswordRule::min(8)->mixedCase()->numbers()->symbols()],
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $credentials = [
            'password' => $password,
            'password_confirmation' => $confirmPassword,
            'token' => $token,
        ];

        try {
            $email = Crypt::decryptString($email);
            $credentials['email'] = $email;
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => ['Invalid encrypted email.']]);
        }

        $userName = '';

        $status = Password::reset(
            $credentials,
            function (User $user, string $password) use (&$userName) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                $userName = $user->name;

                // // Signal to the application that a user's password has been reset
                // // and allowing any other parts of the application that are listening
                // // for this event to react accordingly.
                // event(new PasswordReset($user));
            }
        );


        if ($status == Password::PASSWORD_RESET) {
            if (str_contains($request->route()->getName(), 'admin')) {
                return redirect()->route('admin.authentication.index');
            }
            Mail::to($email)->queue(new PasswordChange($userName));
            return redirect()->route('customer.authentication.index');
        }

        return back()->withErrors(['error' => [__($status)]]);
    }
}
