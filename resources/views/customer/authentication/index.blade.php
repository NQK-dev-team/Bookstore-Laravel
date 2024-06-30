@extends('components.layouts.customer')

@section('preloads')
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            @livewire('authentication.login.customer')
        </div>
    </div>
@endsection

@section('postloads')
@endsection
