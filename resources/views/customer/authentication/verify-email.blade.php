@extends('components.layouts.customer')

@section('preloads')
    <title>Email Verification</title>
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            <form action="{{ route('') }}" method="POST"
                class="bg-white border border-black rounded form my-auto d-flex flex-column px-3 needs-validation">
                @csrf
                <input name="user_type" type="hidden" value="customer">
                <div class='w-100 d-flex flex-column'>
                    <h1 class="text-center mb-0 mt-1">Email Verification</h1>
                    <p></p>
                    <hr>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('postloads')
@endsection
