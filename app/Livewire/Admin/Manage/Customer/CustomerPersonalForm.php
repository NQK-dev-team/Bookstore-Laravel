<?php

namespace App\Livewire\Admin\Manage\Customer;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Reactive;
use App\Http\Controllers\Admin\Manage\Customer;

class CustomerPersonalForm extends Component
{
    #[Reactive]
    public $customerID;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $dob;
    public $gender;
    public $image;
    public $originalEmail;
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

    public function saveInfo()
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->customerID)->whereNull('deleted_at')],
        ]);

        $this->controller->updateEmail($this->customerID, $this->email);
        $this->dispatch('show-update-info-success-modal');
    }

    public function resetForm()
    {
        $this->email = $this->originalEmail;
        $this->clearErrorBag();
    }

    public function render()
    {
        $customer = $this->controller->getCustomer($this->customerID);
        if ($customer) {
            $this->name = $customer->name;
            $this->email = $this->getErrorBag()->has("email") ? $this->email : $customer->email;
            $this->phone = $customer->phone;
            $this->address = $customer->address;
            $this->dob = $customer->dob;
            $this->image = $customer->image;
            $this->gender = $customer->gender;
            $this->originalEmail = $customer->email;
        } else {
            $this->name = '';
            $this->email = $this->getErrorBag()->has("email") ? $this->email : '';
            $this->phone = '';
            $this->address = '';
            $this->dob = '';
            $this->image = '';
            $this->gender = '';
            $this->originalEmail = '';
        }
        return view('livewire.admin.manage.customer.customer-personal-form');
    }
}
