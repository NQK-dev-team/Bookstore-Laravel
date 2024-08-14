@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Discount Coupons</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage discount coupons of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/manage/coupon/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    @livewire('admin.manage.coupon.coupon-list')
@endsection

@section('postloads')
    @livewireScripts
    <script>
        function checkAll() {
            const inputs = document.querySelectorAll('input[type="checkbox"][name="select-books-applied"]');
            inputs.forEach(input => {
                input.checked = true;
                input.dispatchEvent(new Event('change'));
            });
        }

        function unCheckAll() {
            const inputs = document.querySelectorAll('input[type="checkbox"][name="select-books-applied"]');
            inputs.forEach(input => {
                input.checked = false;
                input.dispatchEvent(new Event('change'));
            });
        }

        function checkAllSelected() {
            const inputs = document.querySelectorAll('input[type="checkbox"][name="select-books-applied"]');
            let allChecked = true;
            inputs.forEach(input => {
                if (!input.checked) {
                    allChecked = false;
                    return;
                }
            });
            document.getElementById('checkAll').checked = allChecked;
        }
    </script>
@endsection
