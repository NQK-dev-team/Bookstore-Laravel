<?php

namespace App\Http\Controllers\Customer\Profile;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\PasswordChange;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'phone')->whereNot('id', Auth::user()->id)->whereNull('deleted_at')],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(18)->toDateString()],
            'gender' => 'required|in:M,F,O',
            'address' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index', ['option' => 1])->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $data = User::find(Auth::user()->id);
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->dob = $request->dob;

            if ($request->hasFile('image')) {
                $imagePath = Storage::putFileAs('files/images/users/' . Auth::user()->id, $request->file('image'), date('YmdHis', time()) . '.' . $request->file('image')->extension());
                $data->image = $imagePath;
            }

            $data->save();
        });

        return redirect()->route('customer.profile.index', ['option' => 1]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'newPassword' => ['required', 'string', 'different:currentPassword', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index', ['option' => 3])->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            User::where([['id', '=', Auth::user()->id]])->update([
                'password' => Hash::make($request->newPassword),
            ]);
        });
        Mail::to(Auth::user()->email)->queue(new PasswordChange(Auth::user()->name));
        session()->flash('password-changed', 1);

        return redirect()->route('customer.profile.index', ['option' => 3]);
    }

    public function show(Request $request)
    {
        $option = $request->query('option', 1);
        return view('customer.profile.index', ['option' => $option]);
    }
}
