<?php

namespace App\Livewire\Customer\Book\List;

use App\Models\Book;
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

    public $booksPerPage;
    public $listOption;
    public $searchBook;

    public $books;

    public $pageIndex;
    public $disableNext;
    private $numberOfBooks;

    public function __construct()
    {
        $this->categories = (new BookListController)->getTopCategories();
        $this->selectedCategory = '';

        $this->publishers = (new BookListController)->getTopPublishers();
        $this->selectedPublisher = '';

        $this->authors = (new BookListController)->getTopAuthors();
        $this->selectedAuthor = '';

        $this->booksPerPage = 12;
        $this->listOption = 1;
        $this->searchBook = '';

        $this->resetPageIndex(true);
    }

    #[On('select-publisher-modal')]
    public function selectPublisher($publisher, $called = false)
    {
        if ($publisher === $this->selectedPublisher)
            $this->selectedPublisher = '';
        else
            $this->selectedPublisher = $publisher;

        if (!$called)
            $this->dispatch('select-publisher', publisher: $this->selectedPublisher, called: true);
        else
            $this->dispatch('search-book');
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
        else
            $this->dispatch('search-book');
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
        else
            $this->dispatch('search-book');
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

    #[On('search-book')]
    public function searchBook()
    {
        $this->numberOfBooks = Book::count();
        $temp = (new BookListController)->searchBook($this->selectedAuthor, $this->selectedCategory, $this->selectedPublisher, $this->searchBook, $this->pageIndex - 1, $this->booksPerPage);
        if (!$temp) {
            $this->pageIndex--;
            $this->disableNext = true;
        } else {
            $this->books = $temp;
            $this->disableNext = false;
        }
    }

    public function nextPage()
    {
        $this->numberOfBooks = Book::count();
        if ($this->pageIndex * $this->booksPerPage < $this->numberOfBooks) {
            $this->pageIndex++;
            $this->searchBook();
        }
    }

    public function previousPage()
    {
        if ($this->pageIndex > 1) {
            $this->pageIndex--;
            $this->searchBook();
        }
    }

    public function resetPageIndex($partOfConstructor = false)
    {
        $this->pageIndex = 1;
        $this->numberOfBooks = Book::count();
        if ($this->pageIndex * $this->booksPerPage >= $this->numberOfBooks)
            $this->disableNext = true;
        else
            $this->disableNext = false;

        if (!$partOfConstructor)
            $this->searchBook();
    }

    public function mount()
    {
        $this->searchBook();
    }

    public function render()
    {
        return view('livewire.customer.book.list.book-list');
    }
}
