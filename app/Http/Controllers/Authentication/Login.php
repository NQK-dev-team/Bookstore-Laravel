<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function adminShow()
    {
        return view('admin.authentication.index');
    }

    public function login($email, $password)
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return false;
        }
        return true;
    }

    public function customerShow()
    {
        return view('customer.authentication.index');
    }
}
