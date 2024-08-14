<?php

namespace App\Livewire\Customer\Book\List;

use App\Models\Book;
use Livewire\Component;
use App\Http\Controllers\Customer\Book\BookController;

class BookList extends Component
{
    public $category;
    public $categories;
    public $selectedCategory;

    public $publisher;
    public $publishers;
    public $selectedPublisher;

    public $author;
    public $authors;
    public $selectedAuthor;

    public $booksPerPage;
    public $listOption;
    public $searchBookInput;

    public $books;

    public $pageIndex;
    public $disableNext;
    public $numberOfBooks;

    public $booksPerRow;

    private $controller;

    public function __construct()
    {
        $this->controller = new BookController();
    }

    public function mount()
    {
        $this->categories = $this->controller->getTopCategories();
        $this->selectedCategory = '';
        $this->category = '';

        $this->publishers = $this->controller->getTopPublishers();
        $this->selectedPublisher = '';
        $this->publisher = '';

        $this->authors = $this->controller->getTopAuthors();
        $this->selectedAuthor = '';
        $this->author = '';

        $this->booksPerPage = 12;
        $this->listOption = 1;
        $this->searchBookInput = '';

        $this->pageIndex = 1;
        $this->disableNext = true;
        $this->booksPerRow = 0;

        $this->resetPageIndex();
    }

    public function setBookPerRow($booksPerRow)
    {
        $this->booksPerRow = $booksPerRow;
    }

    public function selectPublisher($publisher)
    {
        if ($publisher === $this->selectedPublisher)
            $this->selectedPublisher = '';
        else
            $this->selectedPublisher = $publisher;
        $this->searchBook();
    }

    public function searchPublisher()
    {
        if ($this->publisher) {
            $this->publishers = [];
            $temp = $this->controller->searchPublisher($this->publisher);
            foreach ($temp as $elem) {
                $this->publishers[] = $elem->publisher;
            }
        } else
            $this->publishers = $this->controller->getTopPublishers();
    }

    public function selectCategory($category)
    {
        if ($category === $this->selectedCategory)
            $this->selectedCategory = '';
        else
            $this->selectedCategory = $category;
        $this->searchBook();
    }

    public function searchCategory()
    {
        if ($this->category) {
            $this->categories = [];
            $temp = $this->controller->searchCategory($this->category);
            foreach ($temp as $elem) {
                $this->categories[] = $elem->name;
            }
        } else
            $this->categories = $this->controller->getTopCategories();
    }

    public function selectAuthor($author)
    {
        if ($author === $this->selectedAuthor)
            $this->selectedAuthor = '';
        else
            $this->selectedAuthor = $author;
        $this->searchBook();
    }

    public function searchAuthor()
    {
        if ($this->author) {
            $this->authors = [];
            $temp = $this->controller->searchAuthor($this->author);
            foreach ($temp as $elem) {
                $this->authors[] = $elem->name;
            }
        } else
            $this->authors = $this->controller->getTopAuthors();
    }

    public function searchBook()
    {
        $temp = $this->controller->searchBook(
            $this->listOption,
            $this->selectedAuthor ? $this->selectedAuthor : '%',
            $this->selectedCategory ? $this->selectedCategory : '%',
            $this->selectedPublisher ? $this->selectedPublisher : '%',
            $this->searchBookInput,
            $this->pageIndex - 1,
            $this->booksPerPage
        );
        $this->books = $temp;

        $this->numberOfBooks = Book::count();
        if ($this->pageIndex * $this->booksPerPage >= $this->numberOfBooks || count($this->books) < $this->booksPerPage)
            $this->disableNext = true;
        else
            $this->disableNext = false;
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

    public function resetPageIndex()
    {
        $this->pageIndex = 1;
        $this->searchBook();
    }

    public function render()
    {
        foreach ($this->books as $book)
            refineBookData($book, false);
        return view('livewire.customer.book.list.book-list');
    }
}
