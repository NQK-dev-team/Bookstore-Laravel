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
    <div class="container-xxl my-3 px-1 px-xl-3">
        <div class='d-flex'>
            <div class='d-none d-xl-block'>
                <div class="panel border-2 me-4 bg-white p-3 rounded">
                    @livewire('customer.book.list.category')
                    @livewire('customer.book.list.author')
                    @livewire('customer.book.list.publisher')
                </div>
            </div>
            @livewire('customer.book.list.book-list')
        </div>
    </div>
    @livewire('customer.book.list.request-book')
@endsection

@section('postloads')
    @livewireScripts
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
@endsection
