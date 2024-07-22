@extends('components.layouts.customer')

@section('preloads')
    <title>Welcome to Laravel</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="book name" content="{{ $book->name }}">
    <meta name="description" content="{{ $book->description }}">
    <meta name="author" content="{{ $book->author }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/book/detail/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class="container bg-light rounded p-3 mt-3">
            <div class="row">
                <div class="col-12 col-md-5 d-flex flex-column align-items-center px-3 mt-3">
                    <img src="{{ $book->image }}" class="rounded img-size"
                        alt="{{ $book->name }} {{ $book->edition }} image">
                </div>
                <div class="col-12 col-md-7 mt-md-0 mt-3">
                    <h1>{{ $book->name }}</h1>
                    <p class="fw-medium">{{ $book->edition }}</p>
                    <p>ISBN: {{ $book->isbn }}</p>
                    <p>Author: {{ $book->authors }}</p>
                    <p>Category: {{ $book->categories }}</p>
                    <p>Publisher: {{ $book->publisher }} </p>
                    <p>Publication date: {{ $book->publication_date }}</p>
                    @livewire('customer.book.detail.average-rating')
                    @livewire('customer.book.detail.book-cart')
                </div>
            </div>
            <div class='mt-4'>
                <h5>Description: </h5>
                <p class="text-justify">{{ $book->description }}</p>
            </div>
        </div>
        @livewire('customer.book.detail.rating')
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="Error modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Error</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>An error has occurred please try again.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noticeModal1" tabindex="-1" aria-labelledby="Notice modal 1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>You have already bought this ebook.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noticeModal2" tabindex="-1" aria-labelledby="Notice modal 2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>You have already had this ebook in your shopping cart.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal1" tabindex="-1" aria-labelledby="Success modal 1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Hardcover has been added to cart.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal2" tabindex="-1" aria-labelledby="Success modal 2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Ebook has been added to cart.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts

    <script>
        window.addEventListener('cart-error', event => {
            const errorModal = new bootstrap.Modal('#errorModal');
            errorModal.toggle();
        });

        window.addEventListener('notice-bought', event => {
            const modal = new bootstrap.Modal('#noticeModal1');
            modal.toggle();
        });

        window.addEventListener('notice-in-cart', event => {
            const modal = new bootstrap.Modal('#noticeModal2');
            modal.toggle();
        });

        window.addEventListener('notice-add-to-cart-1', event => {
            const modal = new bootstrap.Modal('#successModal1');
            modal.toggle();
        });

        window.addEventListener('notice-add-to-cart-2', event => {
            const modal = new bootstrap.Modal('#successModal2');
            modal.toggle();
        });
    </script>
@endsection
