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
    <div class='d-none' x-init="if ({{ session('book-added') ? 1 : 0 }}) $dispatch('create-success');"></div>
    @livewire('admin.manage.book.book-list')

    <div class="modal fade" id="createSuccess" tabindex="-1" aria-labelledby="Create success modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>New book added.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script>
        window.addEventListener('create-success', event => {
            new bootstrap.Modal(document.getElementById('createSuccess')).toggle();
        });

        // document.getElementById('createSuccess').addEventListener('hidden.bs.modal', function() {
        //     window.location.href = '{{ route('admin.manage.book.index') }}';
        // });
    </script>
@endsection
