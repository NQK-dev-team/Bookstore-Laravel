@extends('components.layouts.customer')

@section('preloads')
    <title>Browse Books</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Browse book list of NQK bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/book/list/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class="container-xl my-3 px-1 px-xl-3">
        <div class='d-flex'>
            <div class='d-none d-xl-block panel border-2 me-4 bg-white p-3 rounded'>
                @livewire('customer.book.list.category')
                @livewire('customer.book.list.author')
                @livewire('customer.book.list.publisher')
            </div>
            @livewire('customer.book.list.book-list')
        </div>
    </div>
    @livewire('customer.book.list.request-book')
    {{-- <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            <h4>Category</h4>
                            <input onchange='fetchCategoryList()' id='categorySearchModal' class="form-control"
                                type="search" placeholder="Search" aria-label="Search by categories">
                            <div class='ps-2 mt-3' id='categoryListModal'>
                            </div>
                        </div>
                        <div class='mt-4'>
                            <h4>Author</h4>
                            <input onchange='fetchAuthorList()' id='authorSearchModal' class="form-control"
                                type="search" placeholder="Search" aria-label="Search by authors">
                            <div class='ps-2 mt-3' id='authorListModal'>
                            </div>
                        </div>
                        <div class='mt-4'>
                            <h4>Publisher</h4>
                            <input onchange='fetchPublisherList()' id='publisherSearchModal' class="form-control"
                                type="search" placeholder="Search" aria-label="Search by publishers">
                            <div class='ps-2 mt-3' id='publisherListModal'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" modal fade" id="errorModal" tabindex="-1" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Error</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p id="error_message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Success</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Your request was successfully sent, thank you for your contribution!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('postloads')
    @livewireScripts
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
