<?php

namespace App\Http\Controllers\Admin\Profile;

use Closure;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\User;
use voku\helper\AntiXSS;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Profile extends Controller
{
    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $input = array_map('trim', $input);

        $imageTypes = env('SERVER_ACCEPT_IMAGE', 'mimes:jpeg,png,jpg');
        $imageTypes = str_replace('mimes:', '', $imageTypes);
        $imageTypes = explode(',', $imageTypes);
        $imageTypes = implode(', ', $imageTypes);

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'phone')->whereNot('id', Auth::user()->id)->whereNull('deleted_at')],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->subYears(18)->toDateString()],
            'gender' => 'required|in:M,F,O',
            'address' => 'nullable|string|max:1000',
            'images' => 'max:1',
            'images.*' => ['nullable', 'image', env('SERVER_ACCEPT_IMAGE', 'mimes:jpeg,png,jpg'), 'max:2048'],
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old.',
            'images.*.mimes' => "The image must be a file of type: {$imageTypes}.",
            'images.*.max' => 'The image size must not be greater than 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.profile.index', ['option' => 1])->withErrors($validator)->withInput();
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($request, $input, $antiXss) {
            $data = User::find(Auth::user()->id);
            $data->name = $antiXss->xss_clean($input['name']);
            $data->phone = $antiXss->xss_clean($input['phone']);
            $data->gender = $antiXss->xss_clean($input['gender']);
            $data->address = $antiXss->xss_clean($input['address']);
            $data->dob = $antiXss->xss_clean($input['dob']);

            if ($request->hasFile('images')) {
                $date = new DateTime('now', new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')));
                $imagePath = Storage::putFileAs('files/images/users/admins/' . Auth::user()->id, $request->file('images')[0], $date->format('YmdHis') . '.' . $request->file('images')[0]->extension());
                $data->image = $imagePath;
            }

            $data->save();

            session()->flash('info-updated', 1);
        });

        return redirect()->route('admin.profile.index', ['option' => 1]);
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $input = array_map('trim', $input);

        $validator = Validator::make($input, [
            'currentPassword' => ['required', 'string', function (string $attribute, mixed $value, Closure $fail) {
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
            return redirect()->route('admin.profile.index', ['option' => 2])->withErrors($validator)->withInput();
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($input, $antiXss) {
            User::where([['id', '=', Auth::user()->id]])->update([
                'password' => Hash::make($antiXss->xss_clean($input['newPassword'])),
            ]);
        });
        session()->flash('password-changed', 1);

        return redirect()->route('admin.profile.index', ['option' => 2]);
    }

    public function show(Request $request)
    {
        $option = $request->query('option', 1);
        return view('admin.profile.index', ['option' => $option]);
    }
}
