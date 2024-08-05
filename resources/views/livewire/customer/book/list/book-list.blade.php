<div class='d-flex' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
    tooltipTriggerEl))">
    <div class='d-none d-xl-block'>
        <div class="panel border-2 me-4 bg-white p-3 rounded">
            <form wire:submit="searchCategory">
                <h5>Category</h5>
                <div class="d-flex align-items-center">
                    <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
                        type="submit">
                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                </path>
                            </g>
                        </svg>
                    </button>
                    <input id="search_category" class="form-control search_form" type="search"
                        placeholder="Search category" aria-label="Search category" wire:model="category">
                </div>
                <div class='ps-2 mt-2 item-list'>
                    @foreach ($categories as $category)
                        <p>
                            <span class="pointer {{ $selectedCategory === $category ? 'item-chosen' : '' }}"
                                x-on:click="$wire.selectCategory(`{{ $category }}`)" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-title="{{ getCategoryDescription($category) }}">
                                {{ $category }}</span>
                        </p>
                    @endforeach
                </div>
            </form>
            <form class='mt-4' wire:submit="searchAuthor">
                <h5>Author</h5>
                <div class="d-flex align-items-center">
                    <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
                        type="submit">
                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                </path>
                            </g>
                        </svg>
                    </button>
                    <input id="search_author" class="form-control search_form" type="search"
                        placeholder="Search author" aria-label="Search author" wire:model="author">
                </div>
                <div class='ps-2 mt-2 item-list'>
                    @foreach ($authors as $author)
                        <p class="pointer {{ $selectedAuthor === $author ? 'item-chosen' : '' }}"
                            x-on:click="$wire.selectAuthor(`{{ $author }}`)">{{ $author }}</p>
                    @endforeach
                </div>
            </form>
            <form class='mt-4' wire:submit="searchPublisher">
                <h5>Publisher</h5>
                <div class="d-flex align-items-center">
                    <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
                        type="submit">
                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                </path>
                            </g>
                        </svg>
                    </button>
                    <input id="search_publisher" class="form-control search_form" type="search"
                        placeholder="Search publisher" aria-label="Search publisher" wire:model="publisher">
                </div>
                <div class='ps-2 mt-2 item-list'>
                    @foreach ($publishers as $publisher)
                        <p class="pointer {{ $selectedPublisher === $publisher ? 'item-chosen' : '' }}"
                            x-on:click="$wire.selectPublisher(`{{ $publisher }}`)">{{ $publisher }}</p>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
    <div class='flex-grow-1 border-2 bg-white d-flex flex-column px-1 px-sm-2 rounded' x-data="{
        checkScreenWidth() {
            const screenWidth = window.innerWidth;

            if (screenWidth < 576 && $wire.booksPerRow !== 1)
                $wire.setBookPerRow(1);
            else if (screenWidth >= 576 && screenWidth < 675 && $wire.booksPerRow !== 2)
                $wire.setBookPerRow(2);
            else if (screenWidth >= 675 && $wire.booksPerRow !== 3)
                $wire.setBookPerRow(3);
        }
    }"
        x-init="checkScreenWidth()" x-on:resize.window="checkScreenWidth()" {{-- style="height:{{ $booksPerPage === 12 ? '3000' : ($booksPerPage === 24 ? '6000' : '12000') }}px" --}}>
        <form class="d-flex align-items-center w-100 mt-3" role="search" wire:submit="searchBook">
            <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
                type="submit">
                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                        </path>
                    </g>
                </svg>
            </button>

            <input wire:model="searchBookInput" id="search_book" class="form-control search_form" type="search"
                placeholder="Search book by name" aria-label="Search for books">
        </form>
        <div class='d-flex mt-3'>
            <div class='d-sm-flex'>
                <div>
                    <select id='listOption' class="form-select pointer" aria-label="Select listing option"
                        wire:model.live="listOption" x-on:change="$wire.resetPageIndex()">
                        <option value="1">Default Listing</option>
                        <option value="2">On Sale</option>
                        <option value="3">This Week Best Sellers</option>
                        <option value="4">Price: Low to High</option>
                        <option value="5">Price: High to Low</option>
                    </select>
                </div>
                <div class='ms-sm-3 mt-3 mt-sm-0'>
                    <select id='listLimit' class="form-select pointer" aria-label="Select number of books per page"
                        wire:model.live="booksPerPage" x-on:change="$wire.resetPageIndex()">
                        <option value="12">12 books</option>
                        <option value="24">24 books</option>
                        <option value="48">48 books</option>
                    </select>
                </div>
            </div>
            <div class='d-block d-xl-none ms-3'>
                <button type="button" class="btn border border-1 border-secondary" data-bs-toggle="modal"
                    data-bs-target="#filterModal"><svg width="24px" height="24px" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M14 20.5H10C9.80189 20.4974 9.61263 20.4176 9.47253 20.2775C9.33244 20.1374 9.25259 19.9481 9.25 19.75V12L3.9 4.69C3.81544 4.58007 3.76395 4.44832 3.75155 4.31018C3.73915 4.17204 3.76636 4.03323 3.83 3.91C3.89375 3.78712 3.98984 3.68399 4.10792 3.61173C4.226 3.53947 4.36157 3.50084 4.5 3.5H19.5C19.6384 3.50084 19.774 3.53947 19.8921 3.61173C20.0101 3.68399 20.1062 3.78712 20.17 3.91C20.2336 4.03323 20.2608 4.17204 20.2484 4.31018C20.236 4.44832 20.1846 4.58007 20.1 4.69L14.75 12V19.75C14.7474 19.9481 14.6676 20.1374 14.5275 20.2775C14.3874 20.4176 14.1981 20.4974 14 20.5ZM10.75 19H13.25V11.75C13.2492 11.5907 13.302 11.4357 13.4 11.31L18 5H6L10.62 11.31C10.718 11.4357 10.7708 11.5907 10.77 11.75L10.75 19Z"
                                fill="#000000"></path>
                        </g>
                    </svg><span class='d-none d-sm-inline'>&nbsp;Filter</span></button>
            </div>
            <div class="btn-group d-none d-xl-inline-flex ms-3">
                <button name="previous" type="button"
                    class="btn btn-light fw-medium border border-1 border-secondary" wire:click="previousPage()"
                    {{ $pageIndex === 1 ? 'disabled' : '' }}>&lt;</button>
                <button type="button" class="btn btn-light fw-medium border border-1 border-secondary" disabled
                    name="offset">{{ $pageIndex }}</button>
                <button name="next" type="button"
                    class="btn btn-light fw-medium border border-1 border-secondary" wire:click="nextPage()"
                    {{ $disableNext ? 'disabled' : '' }}>&gt;</button>
            </div>
        </div>
        <hr>
        <div class='d-flex flex-column'>
            @if ($booksPerRow !== 0)
                @foreach ($books as $index => $book)
                    {{-- @php
                        refineBookData($book);
                    @endphp --}}
                    @if ($index % $booksPerRow === 0)
                        <div class="row my-4">
                    @endif
                    <div class="col-{{ 12 / $booksPerRow }}">
                        <a class='bg-white card px-3 py-2 text-decoration-none mx-auto'
                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'>
                            <img class="card-img-top" src="{{ $book->image }}"
                                alt="{{ $book->name }} {{ $book->edition }} image">
                            <div class="card-body p-1 pt-2">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <p class="card-text">{{ $book->edition }}</p>
                                <p class="card-text">Author: {{ $book->authors }}</p>
                                @if ($book->discount)
                                    <span class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                @endif
                                <div class='d-flex mt-3'>
                                    <p class='text-nowrap'>Hardcover:</p>
                                    <p
                                        class='{{ $book->physicalCopy && $book->physicalCopy->quantity !== null && $book->physicalCopy->price !== null && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->physicalCopy && $book->physicalCopy->quantity !== null && $book->physicalCopy->price !== null ? '$' . $book->physicalCopy->price : 'N/A' }}
                                    </p>
                                    @if (
                                        $book->physicalCopy &&
                                            $book->physicalCopy->quantity !== null &&
                                            $book->physicalCopy->price !== null &&
                                            $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                                <div class='d-flex'>
                                    <p class='text-nowrap'>E-book:</p>
                                    <p
                                        class='{{ $book->fileCopy && $book->fileCopy->path !== null && $book->fileCopy->price !== null && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->fileCopy && $book->fileCopy->path !== null && $book->fileCopy->price !== null ? '$' . $book->fileCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->fileCopy && $book->fileCopy->path !== null && $book->fileCopy->price !== null && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @if ($index % $booksPerRow === $booksPerRow - 1 || $index === count($books) - 1)
        </div>
        @endif
        @endforeach
        @endif
    </div>
    <div class='mx-auto mb-3 mt-auto'>
        <div class="btn-group mt-3">
            <button name="previous" type="button" class="btn btn-light fw-medium border border-1 border-secondary"
                wire:click="previousPage()" {{ $pageIndex === 1 ? 'disabled' : '' }}>&lt;</button>
            <button type="button" class="btn btn-light fw-medium border border-1 border-secondary" disabled
                name="offset">{{ $pageIndex }}</button>
            <button name="next" type="button" class="btn btn-light fw-medium border border-1 border-secondary"
                wire:click="nextPage()" {{ $disableNext ? 'disabled' : '' }}>&gt;</button>
        </div>
    </div>
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="modalLabel" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Filter</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="searchCategory">
                        <h5>Category</h5>
                        <div class="d-flex align-items-center">
                            <button title='Submit search form'
                                class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#000000"
                                    stroke-width="1.568">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                        </path>
                                    </g>
                                </svg>
                            </button>
                            <input id="search_category_modal" class="form-control search_form" type="search"
                                placeholder="Search category" aria-label="Search category" wire:model="category">
                        </div>
                        <div class='ps-2 mt-2'>
                            @foreach ($categories as $category)
                                <p>
                                    <span class="pointer {{ $selectedCategory === $category ? 'item-chosen' : '' }}"
                                        x-on:click="$wire.selectCategory(`{{ $category }}`)"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ getCategoryDescription($category) }}">
                                        {{ $category }}
                                    </span>
                                </p>
                            @endforeach
                        </div>
                    </form>
                    <form class='mt-4' wire:submit="searchAuthor">
                        <h5>Author</h5>
                        <div class="d-flex align-items-center">
                            <button title='Submit search form'
                                class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#000000"
                                    stroke-width="1.568">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                        </path>
                                    </g>
                                </svg>
                            </button>
                            <input id="search_author_modal" class="form-control search_form" type="search"
                                placeholder="Search author" aria-label="Search author" wire:model="author">
                        </div>
                        <div class='ps-2 mt-2'>
                            @foreach ($authors as $author)
                                <p class="pointer {{ $selectedAuthor === $author ? 'item-chosen' : '' }}"
                                    x-on:click="$wire.selectAuthor(`{{ $author }}`)">
                                    {{ $author }}</p>
                            @endforeach
                        </div>
                    </form>
                    <form class='mt-4' wire:submit="searchPublisher">
                        <h5>Publisher</h5>
                        <div class="d-flex align-items-center">
                            <button title='Submit search form'
                                class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#000000"
                                    stroke-width="1.568">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                        </path>
                                    </g>
                                </svg>
                            </button>
                            <input id="search_publisher_modal" class="form-control search_form" type="search"
                                placeholder="Search publisher" aria-label="Search publisher" wire:model="publisher">
                        </div>
                        <div class='ps-2 mt-2'>
                            @foreach ($publishers as $publisher)
                                <p class="pointer {{ $selectedPublisher === $publisher ? 'item-chosen' : '' }}"
                                    x-on:click="$wire.selectPublisher(`{{ $publisher }}`)">
                                    {{ $publisher }}
                                </p>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
