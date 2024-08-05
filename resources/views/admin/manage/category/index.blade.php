@extends('components.layouts.admin')

@section('preloads')
    <title>Manage Categories</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Manage categories of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @livewireStyles
@endsection

@section('page')
    @livewire('admin.manage.category.category-list')
@endsection

@section('postloads')
    @livewireScripts
@endsection
