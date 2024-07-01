<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

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
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'phone')->whereNull('deleted_at')],
            'dob' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'address' => 'nullable|string|max:1000',
            'refEmail' => ['nullable', 'email', Rule::exists('users', 'email')->whereNull('deleted_at')],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirmPassword' => 'required|same:password',
        ]);

        // Email verification
    }
}
