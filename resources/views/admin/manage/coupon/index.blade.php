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
@endsection
