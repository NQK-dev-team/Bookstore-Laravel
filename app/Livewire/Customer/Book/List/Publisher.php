<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use App\Http\Controllers\Customer\Book\List\BookList;

class Publisher extends Component
{
    public $publishers;
    public $publisher;
    public $selectedPublisher;

    public function selectPublisher($publisher)
    {
        if ($publisher === $this->selectedPublisher)
            $this->selectedPublisher = '';
        else
            $this->selectedPublisher = $publisher;

        $this->dispatch('select-publisher', selectedPublisher: $this->selectedPublisher);
    }

    public function searchPublisher()
    {
        if ($this->publisher) {
            $this->publishers = [];
            $temp = (new BookList)->searchPublisher($this->publisher);
            foreach ($temp as $elem) {
                $this->publishers[] = $elem->publisher;
            }
        } else
            $this->publishers = (new BookList)->getTopPublishers();
    }

    public function mount()
    {
        $this->publishers = (new BookList)->getTopPublishers();
        $this->selectedPublisher = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.publisher');
    }
}
