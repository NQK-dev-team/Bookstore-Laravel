<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use App\Mail\ReferralNotice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Encryption\DecryptException;

class Register extends Controller
{
    public function show()
    {
        return view('customer.authentication.register');
    }

    public function register(Request $request)
    {
        session()->flash('name', $request->name);
        session()->flash('email', $request->email);
        session()->flash('phone', $request->phone);
        session()->flash('gender', $request->gender);
        session()->flash('dob', $request->dob);
        session()->flash('address', $request->address);
        session()->flash('password', $request->password);
        session()->flash('confirmPassword', $request->confirmPassword);
        session()->flash('refEmail', $request->refEmail);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'phone')->whereNull('deleted_at')],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->subYears(18)->toDateString()],
            'gender' => 'required|in:M,F,O',
            'address' => 'nullable|string|max:1000',
            'refEmail' => ['nullable', 'email', Rule::exists('users', 'email')->whereNull('deleted_at')],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirmPassword' => 'required|same:password',
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',
        ]);

        // Create user, login and redirect to email verification page
        $refID = $request->refEmail ? (User::where('email', $request->refEmail)->first()->id) : null;

        DB::transaction(function () use ($request, $refID) {
            User::create([
                'id' => IdGenerator::generate(['table' => 'users', 'length' => 20, 'prefix' => 'U-C-', 'reset_on_prefix_change' => true]),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'address' => $request->address,
                'gender' => $request->gender,
                'password' =>  Hash::make($request->password),
                'referrer_id' => $refID,
            ]);
        });

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 0])) { {
                $validator = Validator::make($request->all(), []);
                $validator->errors()->add('error_message', 'Error while logging in with new account. Please try again.');
                return back()->withErrors($validator->errors());
            }
        }

        return redirect()->route('customer.authentication.verify-email');
    }

    public function showVerification()
    {
        $email = auth()->user()->email;

        $result = DB::table('email_verify_tokens')->where('email', $email)->first();
        if (!$result) {
            $token = Str::random(32);
            DB::table('email_verify_tokens')->insert(['email' => $email, 'token' => Hash::make($token), 'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))]);
            Mail::to($email)->queue(new VerifyEmail(Crypt::encryptString($email), $token));
        } else {
            if (Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInSeconds($result->created_at) < 0) {
                $token = Str::random(32);
                DB::table('email_verify_tokens')->where('email', $email)->update(['token' => Hash::make($token), 'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))]);
                Mail::to($email)->queue(new VerifyEmail(Crypt::encryptString($email), $token));
            }
        }
        return view('customer.authentication.verify-email', ['email' => $email]);
    }

    public function requestVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $result = DB::table('email_verify_tokens')->where('email', $email)->first();
        $token = Str::random(32);
        while (DB::table('email_verify_tokens')->where('token', Hash::make($token))->first()) {
            $token = Str::random(32);
        }

        if ($result) {
            DB::table('email_verify_tokens')->where('email', $email)->update(['token' => Hash::make($token), 'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))]);
        } else {
            DB::table('email_verify_tokens')->insert(['email' => $email, 'token' => Hash::make($token), 'created_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))]);
        }
        Mail::to($email)->queue(new VerifyEmail(Crypt::encryptString($email), $token));

        return back();
    }

    public function verifyEmail(Request $request)
    {
        try {
            $email = Crypt::decryptString($request->email);
            $token = $request->token;

            $result = DB::table('email_verify_tokens')->where('email', $email)->first();

            // Compare token with hased token
            if (!Hash::check($token, $result->token)) {
                abort(401);
            }

            // If createdTime pass 24 hours from now, return 400 error status code
            if (Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInSeconds($result->created_at) < 0) {
                abort(419);
            }

            // Update user email_verified_at
            DB::transaction(function () use ($email) {
                DB::table('email_verify_tokens')->where('email', $email)->delete();
                User::where('email', $email)->update(['email_verified_at' => Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))]);
            });

            $refID = User::where('email', $email)->first()->referrer_id;
            if ($refID) {
                $ref = User::where('id', $refID)->first();
                Mail::to($ref->email)->queue(new ReferralNotice($ref->name, User::where('email', $email)->first()->name));
            }
        } catch (DecryptException $e) {
            // Return 400 error status code
            abort(400);
        }
        return redirect()->route('customer.index');
    }
}
