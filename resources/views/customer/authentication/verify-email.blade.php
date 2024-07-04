@extends('components.layouts.customer')

@section('preloads')
    <title>Email Verification</title>
    <meta name="author" content="Nghia Duong">
    <meta name="description" content="Verify NQK bookstore email account">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            <form action="" method="POST" id="verify_form"
                class="bg-white border border-black rounded form my-auto d-flex flex-column px-3 needs-validation">
                @csrf
                <input name="user_type" type="hidden" value="customer">
                <input name="email" type="hidden" value="{{ $email }}">
                <div class='w-100 d-flex flex-column'>
                    <h1 class="text-center mb-0 mt-3">Email Verification</h1>
                    <hr>
                    <p class='text-center'>We have sent an email to {{ $email }} to verify your email address and
                        activate your account. The link in the email will expire in 24 hours.</p>
                    <p class='text-center'>Didn't receive the email? <button
                            class='border-0 text-primary bg-transparent fw-medium'>Resend email</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('postloads')
@endsection
