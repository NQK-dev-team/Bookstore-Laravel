<?php

namespace App\Livewire\Authentication\Login;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Authentication\Login;
use Illuminate\Validation\ValidationException;

class Admin extends Component
{
    public $email = '';
    public $password = '';

    public $display = 'd-none';
    public $errorMessage = '';

    public $emailError = '';
    public $passwordError = '';

    public function login()
    {
        try {
            $this->validate([
                'email' => 'required|email',
            ]);
        } catch (ValidationException $e) {
            $this->emailError = $e->validator->errors()->first();
            return;
        }

        $this->emailError = '';

        try {
            $this->validate([
                'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            ]);
        } catch (ValidationException $e) {
            $this->passwordError = $e->validator->errors()->first();
            return;
        }

        $this->passwordError = '';

        $this->errorMessage = '';
        $this->display = 'd-none';

        if (!(new Login)->login($this->email, $this->password)) {
            $this->errorMessage = 'Incorrect email or password';
            $this->display = 'd-flex';
            return;
        }

        return redirect()->route('admin.index');
    }

    public function render()
    {
        return view('livewire.authentication.login.admin');
    }
}
