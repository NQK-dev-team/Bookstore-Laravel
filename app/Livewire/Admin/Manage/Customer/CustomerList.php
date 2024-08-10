<?php

namespace App\Livewire\Admin\Manage\Customer;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use App\Http\Controllers\Admin\Manage\Customer;

class CustomerList extends Component
{
    public $customers;
    public $limit;
    public $offset;
    public $search;
    public $total;
    public $selectedCustomer;
    private $controller;

    public function __construct()
    {
        $this->controller = new Customer();
        $this->search = null;
        $this->selectedCustomer = null;
        $this->limit = 10;
        $this->offset = 0;
    }

    public function searchCustomer($search)
    {
        $this->search = $search;
        $this->resetPagination();
    }

    public function previous()
    {
        if (!($this->offset <= 0))
            $this->offset--;
    }

    public function next()
    {
        if (!(($this->offset + 1) * $this->limit >= $this->total))
            $this->offset++;
    }

    public function resetPagination()
    {
        $this->offset = 0;
    }

    #[On('reset-customer-id')]
    public function resetCustomerSelection()
    {
        $this->selectedCustomer = null;
        $this->dispatch('set-customer-id', selectedCustomer: null);
    }

    public function deleteCustomer()
    {
        $this->controller->deleteCustomer($this->selectedCustomer);
    }

    #[Renderless]
    public function openInfoModal($customerID)
    {
        // $this->selectedCustomer = $customerID;
        $this->dispatch('set-customer-id', selectedCustomer: $customerID);
    }

    public function render()
    {
        $this->total = $this->controller->getTotalCustomers($this->search) ?? 0;
        $this->customers = $this->controller->getCustomers($this->search, $this->limit, $this->offset) ?? [];
        return view('livewire.admin.manage.customer.customer-list');
    }
}
