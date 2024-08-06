@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Customers</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage customers of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/manage/customer/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    @livewire('admin.manage.customer.customer-list')

    <div class="modal fade" id="updateInfoModal" tabindex="-1" aria-labelledby="Update customer email modal"
        x-init="window.addEventListener('show-update-info-success-modal', event => {
            new bootstrap.Modal($el).show();
        });">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Customer email updated.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="Update customer password modal"
        x-init="window.addEventListener('show-update-password-success-modal', event => {
            new bootstrap.Modal($el).show();
        });">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Customer password changed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
@endsection
