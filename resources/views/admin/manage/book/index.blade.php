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
    @livewire('admin.manage.book.book-list')
@endsection

@section('postloads')
    @livewireScripts
@endsection
