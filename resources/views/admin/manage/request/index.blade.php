@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Customer Requests</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage customer book requests of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @livewireStyles
@endsection

@section('page')
    @livewire('admin.manage.request.request-list')
@endsection

@section('postloads')
    @livewireScripts
@endsection
