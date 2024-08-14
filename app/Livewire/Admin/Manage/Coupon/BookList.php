<?php

namespace App\Livewire\Admin\Manage\Coupon;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use App\Http\Controllers\Admin\Manage\Book;
use App\Http\Controllers\Admin\Manage\Coupon;
use Livewire\Attributes\Renderless;

class BookList extends Component
{
    public $couponID;
    public $author;
    public $category;
    public $publisher;
    public $search;
    public $offset;
    public $limit;
    public $books;
    public $total;
    public $selectedBooks;
    public $originalSelectedBooks;
    private $bookController;
    private $couponController;

    public function __construct()
    {
        $this->author = null;
        $this->category = null;
        $this->publisher = null;
        $this->search = null;
        $this->offset = 0;
        $this->limit = 10;
        $this->selectedBooks = [];
        $this->originalSelectedBooks = [];
        $this->bookController = new Book();
        $this->couponController = new Coupon();
    }

    #[On('select-author')]
    public function selectAuthor($author)
    {
        $this->author = $author;
        $this->resetPagination();
    }

    #[On('select-category')]
    public function selectCategory($category)
    {
        $this->category = $category;
        $this->resetPagination();
    }

    #[On('select-publisher')]
    public function selectPublisher($publisher)
    {
        $this->publisher = $publisher;
        $this->resetPagination();
    }

    public function searchBook($search)
    {
        $this->search = ($search === '' || !$search) ? null : $search;
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

    #[On('set-coupon-id')]
    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
        $this->author = null;
        $this->category = null;
        $this->publisher = null;
        $this->search = null;
        $this->offset = 0;
        $this->limit = 10;

        if ($this->couponID) {
            $result = $this->couponController->getBooksApplied($this->couponID);
            $this->selectedBooks = $result->pluck('id')->toArray();
            $this->originalSelectedBooks = $result->pluck('id')->toArray();
        } else {
            $this->selectedBooks = [];
            $this->originalSelectedBooks = [];
        }
    }

    public function resetSelection()
    {
        if ($this->couponID) {
            $result = $this->couponController->getBooksApplied($this->couponID);
            $this->selectedBooks = $result->pluck('id')->toArray();
        } else {
            $this->selectedBooks = [];
        }
        $this->dispatch('set-coupon-id', couponID: $this->couponID)->to(CouponInfo::class);
    }

    #[Renderless]
    public function checkBook($bookID)
    {
        if (!in_array($bookID, $this->selectedBooks)) {
            $this->selectedBooks[] = $bookID;
            $this->dispatch('add-book-applied', bookID: $bookID)->to(CouponInfo::class);
        }
    }

    #[Renderless]
    public function unCheckBook($bookID)
    {
        $index = array_search($bookID, $this->selectedBooks);
        if ($index !== false) {
            unset($this->selectedBooks[$index]);
            $this->dispatch('remove-book-applied', bookID: $bookID)->to(CouponInfo::class);
        }
    }


    public function render()
    {
        $this->total = $this->bookController->getTotal($this->category, $this->author, $this->publisher, $this->search, true) ?? 0;
        $this->books = $this->bookController->getBooks($this->category, $this->author, $this->publisher, $this->search, true, $this->offset, $this->limit) ?? [];
        foreach ($this->books as &$book) {
            refineBookData($book);
        }
        return view('livewire.admin.manage.coupon.book-list');
    }
}
