@extends('components.layouts.customer')

@section('preloads')
    <title>Home</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Home page of NQK bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class='w-100 d-flex flex-column' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
        tooltipTriggerEl))">
        <div class='w-100 sales'>
            <div class='container-xl p-2'>
                <div class='mx-3 bg-white rounded mt-3 py-2 px-2 px-sm-3 d-flex align-items-center'>
                    <img alt='Icon' src='{{ asset('assets/images/flash_sale.png') }}' class='flash_sale_image'>
                    <a aria-label="view more discounted books"
                        href='{{ route('customer.book.index', ['select' => 'discount']) }}'
                        class='text-decoration-none ms-auto fs-5 d-flex align-items-center'>More<svg width="24px"
                            height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                    fill="#007bff"></path>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
            <div class='container-xl p-2 my-3 position-relative'>
                <div class='w-100 h-100 position-absolute align-items-center justify-content-between pe-3 side-navigate '
                    id='saleNavigate'>
                    <div class='slide-button-div'>
                        <button aria-label="Left slide" id='saleScrollLeft'
                            class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0'>
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#828282" transform="rotate(180)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                        fill="#828282"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class='slide-button-div'>
                        <button aria-label="Right slide" id='saleScrollRight'
                            class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0'>
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#828282">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                        fill="#828282"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class='mx-3 d-flex overflow-x-auto hideBrowserScrollbar smooth-scroll' id='saleList'>
                    @foreach ($discountedBooks as $index => $book)
                        @if ($index === 0)
                            <a class='bg-white card px-3 py-2 text-decoration-none me-sm-3 me-2 ms-md-0 ms-2'
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
                                            class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->physicalCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class='d-flex'>
                                        <p class='text-nowrap'>E-book:</p>
                                        <p
                                            class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->fileCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @elseif ($index === count($discountedBooks) - 1)
                            <a class='bg-white card px-3 py-2 text-decoration-none ms-sm-3 ms-2 me-md-0 me-2'
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
                                            class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->physicalCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class='d-flex'>
                                        <p class='text-nowrap'>E-book:</p>
                                        <p
                                            class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->fileCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @else
                            <a class='bg-white card px-3 py-2 text-decoration-none mx-sm-3 mx-2'
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
                                            class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->physicalCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class='d-flex'>
                                        <p class='text-nowrap'>E-book:</p>
                                        <p
                                            class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                            {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                        </p>
                                        @if ($book->fileCopy->price && $book->discount)
                                            <p class='fw-medium'>
                                                ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div aria-label="alpine-function-trigger-element" x-init="addScrollEvent('saleScrollLeft', 'saleScrollRight', 'saleList');
            checkOverflow('saleNavigate', 'saleList');"></div>
        </div>
        @if (count($bestSellingBooks))
            <div class='container-xl p-2 mt-4'>
                <div class='mx-3'>
                    <h4 class='text-white mb-0 text-center banner p-3 rounded-top'>Best Sellers</h4>
                    <div class='bg-white row mx-0 rounded-bottom'>
                        <div class='col-12 col-lg-5 select-border my-3 pe-sm-0'>
                            @foreach ($bestSellingBooks as $index => $book)
                                <a onmouseover="showHoveredBook({{ $index }})"
                                    href='{{ route('customer.book.detail', ['id' => $book->id]) }}'
                                    class='my-4 d-flex flex-column flex-sm-row pointer best-seller text-dark text-decoration-none'>
                                    <img alt='{{ $book->name }} {{ $book->edition }} image' src="{{ $book->image }}"
                                        class="best-seller-img mx-auto mx-sm-0">
                                    <div
                                        class='mx-auto ms-sm-3 me-sm-0 d-flex flex-column align-items-center align-items-sm-start'>
                                        <h5 class='mb-2 mt-2 mt-sm-0 t text-sm-start text-center'>{{ $book->name }}</h5>
                                        <p class='mb-2'>{{ $book->edition }}</p>
                                        <p class='mb-2'>{{ $book->authors }}</p>
                                        <div class='d-flex'>
                                            <div class='text-warning'>
                                                {!! displayRatingStars($book->average_rating) !!}
                                            </div>
                                            <p class='mb-0 ms-2'>({{ $book->average_rating }})</p>
                                        </div>
                                    </div>
                                </a>
                                <hr class='d-sm-none'>
                                </hr>
                            @endforeach
                        </div>
                        <div class='col-lg-7 d-lg-block d-none py-3'>
                            @foreach ($bestSellingBooks as $index => $book)
                                @if ($index === 0)
                                    <div id='bestSellerDetail_{{ $index }}' name='bestSellerDetail'>
                                        <div class='d-flex'>
                                            <img alt='{{ $book->name }} {{ $book->edition }} image'
                                                src="{{ $book->image }}" class="best-seller-img-detail">
                                            <div class='ms-3'>
                                                <h3>{{ $book->name }}</h3>
                                                <p>{{ $book->edition }}</p>
                                                <p>ISBN-13: {{ $book->isbn }}</p>
                                                <p>Author: {{ $book->authors }}</p>
                                                <p>Category:
                                                    @php
                                                        $categories = explode(', ', $book->categories);
                                                    @endphp
                                                    @foreach ($categories as $index => $category)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="{{ getCategoryDescription($category) }}">{{ $category }}{{ $index < count($categories) - 1 ? ', ' : '' }}
                                                        </span>
                                                    @endforeach
                                                </p>
                                                <p>Publisher: {{ $book->publisher }}</p>
                                                <p>Publish Date: {{ $book->publication_date }}</p>
                                                <div class='mb-3 d-flex'>
                                                    <div class='text-warning'>
                                                        {!! displayRatingStars($book->average_rating) !!}
                                                    </div>
                                                    <p class='mb-0 ms-2'>({{ $book->average_rating }})</p>
                                                </div>
                                                @if ($book->discount)
                                                    <span
                                                        class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                                @endif
                                                <div class='d-flex mt-3'>
                                                    <p class='text-nowrap'>Hardcover:</p>
                                                    <p
                                                        class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                                        {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                                    </p>
                                                    @if ($book->physicalCopy->price && $book->discount)
                                                        <p class='fw-medium'>
                                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class='d-flex'>
                                                    <p class='text-nowrap'>E-book:</p>
                                                    <p
                                                        class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                                        {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                                    </p>
                                                    @if ($book->fileCopy->price && $book->discount)
                                                        <p class='fw-medium'>
                                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class='mt-3'>Description</h5>
                                        <p class='text-justify'>{{ $book->description ? $book->description : 'N/A' }}</p>
                                    </div>
                                @else
                                    <div class='none' id='bestSellerDetail_{{ $index }}'
                                        name='bestSellerDetail'>
                                        <div class='d-flex'>
                                            <img alt='{{ $book->name }} {{ $book->edition }} image'
                                                src="{{ $book->image }}" class="best-seller-img-detail">
                                            <div class='ms-3'>
                                                <h3>{{ $book->name }}</h3>
                                                <p>{{ $book->edition }}</p>
                                                <p>ISBN-13: {{ $book->isbn }}</p>
                                                <p>Author: {{ $book->authors }}</p>
                                                <p>Category:
                                                    @php
                                                        $categories = explode(', ', $book->categories);
                                                    @endphp
                                                    @foreach ($categories as $index => $category)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="{{ getCategoryDescription($category) }}">{{ $category }}{{ $index < count($categories) - 1 ? ', ' : '' }}
                                                        </span>
                                                    @endforeach
                                                </p>
                                                <p>Publisher: {{ $book->publisher }}</p>
                                                <p>Publish Date: {{ $book->publication_date }}</p>
                                                <div class='mb-3 d-flex'>
                                                    <div class='text-warning'>
                                                        {!! displayRatingStars($book->average_rating) !!}
                                                    </div>
                                                    <p class='mb-0 ms-2'>({{ $book->average_rating }})</p>
                                                </div>
                                                @if ($book->discount)
                                                    <span
                                                        class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                                @endif
                                                <div class='d-flex mt-3'>
                                                    <p class='text-nowrap'>Hardcover:</p>
                                                    <p
                                                        class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                                        {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                                    </p>
                                                    @if ($book->physicalCopy->price && $book->discount)
                                                        <p class='fw-medium'>
                                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class='d-flex'>
                                                    <p class='text-nowrap'>E-book:</p>
                                                    <p
                                                        class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                                        {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                                    </p>
                                                    @if ($book->fileCopy->price && $book->discount)
                                                        <p class='fw-medium'>
                                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class='mt-3'>Description</h5>
                                        <p class='text-justify'>{{ $book->description ? $book->description : 'N/A' }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class='bg-white d-flex pb-3'>
                        <a class='btn moreBtn mx-auto' href='{{ route('customer.book.index', ['select' => 'sales']) }}'>
                            Browse More</a>
                    </div>
                </div>
            </div>
        @endif
        @livewire('customer.home.top-categories')
        @livewire('customer.home.top-publishers')
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script>
        function checkOverflow(slideNavigateID, listID) {
            const el = document.getElementById(listID);
            const curOverflow = el.style.overflow;

            if (!curOverflow || curOverflow === "visible")
                el.style.overflow = "hidden";

            const isOverflowing = el.clientWidth < el.scrollWidth ||
                el.clientHeight < el.scrollHeight;

            el.style.overflow = curOverflow;
            if (isOverflowing) {
                if (window.innerWidth >= 992)
                    document.getElementById(slideNavigateID).style.display = 'flex';
                else
                    document.getElementById(slideNavigateID).style.display = 'none';
            } else {
                document.getElementById(slideNavigateID).style.display = 'none';
            }
        }

        function addScrollEvent(navigateLeftID, navigateRightID, listID) {
            document.getElementById(navigateRightID).addEventListener('click', function() {
                document.getElementById(listID).scrollLeft += 500;
            });

            document.getElementById(navigateLeftID).addEventListener('click', function() {
                document.getElementById(listID).scrollLeft -= 500;
            });
        }

        function showHoveredBook(index) {
            document.querySelectorAll(`div[name="bestSellerDetail"]:not(#bestSellerDetail_${ index })`).forEach(function(
                div) {
                div.style.display = 'none';
            });

            document.querySelector('#bestSellerDetail_' + index).style.display = 'block';
        }
    </script>
@endsection
