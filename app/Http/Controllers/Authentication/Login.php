<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function login($email, $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return false;
        }
        return true;
    }

    public function show(Request $request)
    {
        if (str_contains($request->route()->getName(), 'admin')) {
            return view('admin.authentication.index');
        }
        return view('customer.authentication.index');
    }
}
