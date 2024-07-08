<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Customer\Book\List\BookList as BookListController;

class BookList extends Component
{
    public $category; // For the pop-up filter
    public $categories; // For the pop-up filter
    public $selectedCategory;

    public $publisher; // For the pop-up filter
    public $publishers; // For the pop-up filter
    public $selectedPublisher;

    public $author; // For the pop-up filter
    public $authors; // For the pop-up filter
    public $selectedAuthor;

    public $bookPerPage;
    public $listOption;
    public $searchBook;

    #[On('select-publisher-modal')]
    public function selectPublisher($publisher, $called = false)
    {
        if ($publisher === $this->selectedPublisher)
            $this->selectedPublisher = '';
        else
            $this->selectedPublisher = $publisher;

        if (!$called)
            $this->dispatch('select-publisher', publisher: $this->selectedPublisher, called: true);
    }

    public function searchPublisher()
    {
        if ($this->publisher) {
            $this->publishers = [];
            $temp = (new BookListController)->searchPublisher($this->publisher);
            foreach ($temp as $elem) {
                $this->publishers[] = $elem->publisher;
            }
        } else
            $this->publishers = (new BookListController)->getTopPublishers();
    }

    #[On('select-category-modal')]
    public function selectCategory($category, $called = false)
    {
        if ($category === $this->selectedCategory)
            $this->selectedCategory = '';
        else
            $this->selectedCategory = $category;

        if (!$called)
            $this->dispatch('select-category', category: $this->selectedCategory, called: true);
    }

    public function searchCategory()
    {
        if ($this->category) {
            $this->categories = [];
            $temp = (new BookListController)->searchCategory($this->category);
            foreach ($temp as $elem) {
                $this->categories[] = $elem->name;
            }
        } else
            $this->categories = (new BookListController)->getTopCategories();
    }

    #[On('select-author-modal')]
    public function selectAuthor($author, $called = false)
    {
        if ($author === $this->selectedAuthor)
            $this->selectedAuthor = '';
        else
            $this->selectedAuthor = $author;

        if (!$called)
            $this->dispatch('select-author', author: $this->selectedAuthor, called: true);
    }

    public function searchAuthor()
    {
        if ($this->author) {
            $this->authors = [];
            $temp = (new BookListController)->searchAuthor($this->author);
            foreach ($temp as $elem) {
                $this->authors[] = $elem->name;
            }
        } else
            $this->authors = (new BookListController)->getTopAuthors();
    }

    public function searchBook()
    {
    }

    public function mount()
    {
        $this->categories = (new BookListController)->getTopCategories();
        $this->selectedCategory = '';

        $this->publishers = (new BookListController)->getTopPublishers();
        $this->selectedPublisher = '';

        $this->authors = (new BookListController)->getTopAuthors();
        $this->selectedAuthor = '';

        $this->bookPerPage = 12;
        $this->listOption = 1;
        $this->searchBook = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.book-list');
    }
}
