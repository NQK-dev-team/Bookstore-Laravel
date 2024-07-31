@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Books</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage books of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/manage/book/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class="container-fluid h-100 d-flex flex-column">
        <h1 class='fs-2 mx-auto mt-3 mb-3'>Book List</h1>
        <div class="mb-2">
            <button class="btn btn-primary btn-sm"><strong>+</strong> Add New Book</button>
        </div>
        <form class="d-flex align-items-center w-100" role="search">
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

            <input id="search_book" class="form-control search_form" type="search"
                placeholder="Search book by name" aria-label="Search for book by name">
        </form>
        <div class="mt-2 d-flex flex-md-row flex-column">
            @livewire('admin.manage.book.category')
            @livewire('admin.manage.book.author')
            @livewire('admin.manage.book.publisher')
        </div>
        <div class="mt-2">
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2">Show</p>
                <div>
                    <select id="entry_select" class="form-select form-select-sm pointer" aria-label="Entry selection">
                        <option value=10 selected>10</option>
                        <option value=25>25</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </div>
                <p class="mb-0 ms-2">entries</p>
            </div>
            <div class="mt-2">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="statusSwitch">Choose
                        active books</label>
                    <input title='Book status' class="form-check-input pointer" type="checkbox" role="switch"
                        id="statusSwitch" checked>
                </div>
            </div>
        </div>
        @livewire('admin.manage.book.book-list')
        <div class="w-100 d-flex flex-sm-row flex-column justify-content-sm-between mb-4 mt-2 align-items-center">
            <div class="d-flex">
                <p>Show&nbsp;</p>
                <p>x</p>
                <p>&nbsp;to&nbsp;</p>
                <p>x</p>
                <p>&nbsp;of&nbsp;</p>
                <p>x</p>
                <p>&nbsp;entries</p>
            </div>
            <div class="group_button">
                <div class="btn-group d-flex" role="group">
                    <button type="button" class="btn btn-outline-info">Previous</button>
                    <button type="button" class="btn btn-info text-white" disabled>1</button>
                    <button type="button" class="btn btn-outline-info">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
@endsection
