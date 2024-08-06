<?php

namespace App\Livewire\Admin\Manage\Customer;

use Closure;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Admin\Manage\Customer;

class CustomerPasswordForm extends Component
{
    #[Reactive]
    public $customerID;
    public $newPassword;
    public $confirmPassword;
    public $email;
    private $controller;

    public function __construct()
    {
        $this->controller = new Customer();
    }

    #[On('clear-error-bag')]
    public function clearErrorBag()
    {
        $this->resetErrorBag();
    }

    public function updatePassword()
    {
        $this->validate([
            'newPassword' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(),
            function (string $attribute, mixed $value, Closure $fail) {
                if (Hash::check($value, $this->controller->getCustomer($this->customerID)->password)) {
                    $fail('New password is the same as the current password.');
                }
            }],
            'confirmPassword' => 'required|same:newPassword',
        ]);

        $this->controller->updatePassword($this->customerID, $this->newPassword);
        $this->dispatch('show-update-password-success-modal');
    }

    public function render()
    {
        $customer = $this->controller->getCustomer($this->customerID);
        if ($customer) {
            $this->email = $customer->email;
            $this->newPassword = $this->getErrorBag()->has("newPassword") || $this->getErrorBag()->has("confirmPassword") ? $this->newPassword : '';
            $this->confirmPassword = $this->getErrorBag()->has("confirmPassword") || $this->getErrorBag()->has("newPassword") ? $this->confirmPassword : '';
        } else {
            $this->email =  '';
            $this->newPassword = '';
            $this->confirmPassword = '';
        }
        return view('livewire.admin.manage.customer.customer-password-form');
    }
}
