<?php

namespace App\Livewire\Customer\Book\List;

use App\Models\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Livewire\Component;

class RequestBook extends Component
{
    public $bookName;
    public $author;

    public function submit()
    {
        $this->validate([
            'bookName' => 'required',
            'author' => 'required',
        ]);

        Request::create([
            'id' =>  IdGenerator::generate(['table' => 'requests', 'length' => 20, 'prefix' => 'REQ-']),
            'name' => $this->bookName,
            'author' => $this->author,
        ]);

        $this->reset();
    }

    public function updated()
    {
        $this->dispatch('openSuccessModal');
    }

    public function render()
    {
        return view('livewire.customer.book.list.request-book');
    }
}
