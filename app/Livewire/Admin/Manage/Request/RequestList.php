<?php

namespace App\Livewire\Admin\Manage\Request;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Request;

class RequestList extends Component
{
    public $requests;
    public $limit;
    public $offset;
    public $total;
    public $selectedRequest;
    private $controller;

    public function __construct()
    {
        $this->controller = new Request();
        $this->limit = 10;
        $this->offset = 0;
        $this->selectedRequest = null;
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

    public function deleteRequest()
    {
        $this->controller->deleteRequest($this->selectedRequest);
    }

    #[On('reset-request-id')]
    public function resetRequestSelection()
    {
        $this->selectedRequest = null;
    }

    public function render()
    {
        $this->total = $this->controller->getTotalRequests();
        $this->requests = $this->controller->getRequests($this->limit, $this->offset);
        return view('livewire.admin.manage.request.request-list');
    }
}
