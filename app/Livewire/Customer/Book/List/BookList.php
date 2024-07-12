<?php

namespace App\Livewire\Customer\Book\List;

use App\Models\Book;
use Livewire\Component;
use App\Http\Controllers\Customer\Book\BookList as BookListController;

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

    public function mount()
    {
        $this->categories = (new BookListController)->getTopCategories();
        $this->selectedCategory = '';
        $this->category = '';

        $this->publishers = (new BookListController)->getTopPublishers();
        $this->selectedPublisher = '';
        $this->publisher = '';

        $this->authors = (new BookListController)->getTopAuthors();
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
            $temp = (new BookListController)->searchPublisher($this->publisher);
            foreach ($temp as $elem) {
                $this->publishers[] = $elem->publisher;
            }
        } else
            $this->publishers = (new BookListController)->getTopPublishers();
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
            $temp = (new BookListController)->searchCategory($this->category);
            foreach ($temp as $elem) {
                $this->categories[] = $elem->name;
            }
        } else
            $this->categories = (new BookListController)->getTopCategories();
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
            $temp = (new BookListController)->searchAuthor($this->author);
            foreach ($temp as $elem) {
                $this->authors[] = $elem->name;
            }
        } else
            $this->authors = (new BookListController)->getTopAuthors();
    }

    public function searchBook()
    {
        $temp = (new BookListController)->searchBook(
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
        return view('livewire.customer.book.list.book-list');
    }
}
