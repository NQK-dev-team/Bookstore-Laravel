<?php

namespace App\Livewire\Authentication\Login;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Authentication\Login;
use Illuminate\Validation\ValidationException;

class Customer extends Component
{
    public $email = '';
    public $password = '';

    public $display = 'd-none';
    public $errorMessage = '';

    public function login()
    {
        try {
            $this->validate([
                'email' => 'required|email',
                'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()]
            ]);

            if (!(new Login)->login($this->email, $this->password)) {
                $this->errorMessage = 'Invalid email or password';
                $this->display = 'd-flex';
                return;
            }

            $this->errorMessage = '';
            $this->display = 'd-none';

            return redirect()->route('customer.index');
        } catch (ValidationException $e) {
            $this->errorMessage = $e->validator->errors()->first();
            $this->display = 'd-flex';
            return;
        }
    }

    public function render()
    {
        return view('livewire.authentication.login.customer');
    }
}
