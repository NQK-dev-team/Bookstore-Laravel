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
        @livewire('customer.book.list.book-list')
    </div>
    @livewire('customer.book.list.request-book')
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="modalLabel" wire:ignore.self>
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
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        window.addEventListener('openSuccessModal', event => {
            const successModal = new bootstrap.Modal('#successModal');
            successModal.toggle();
        });

        document.getElementById('successModal').addEventListener('hidden.bs.modal', function() {
            document.getElementsByClassName('modal-backdrop')[0].remove();

            // Remove all styles and classes added by bootstrap in the body tag
            document.body.classList.remove('modal-open');
            document.body.style = '';
        });
    </script>
@endsection
