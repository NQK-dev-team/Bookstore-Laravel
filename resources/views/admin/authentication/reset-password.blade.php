@extends('components.layouts.admin')

@section('preloads')
    <title>Recovery</title>
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            <form class="bg-white border border-black rounded form my-auto flex-column px-3 d-flex" action=""
                method="POST">
                @csrf
                <input name="user_type" type="hidden" value="admin">
                <input name="token" type="hidden" value="{{ $token }}">
                <input type="hidden" value="{{ $email }}" name="email" autocomplete="email">
                <input hidden type="text" autocomplete="username" value="..." name="...">
                <h1 class='text-center mt-3'>Reset your password</h1>
                <p class='text-center mt-3'>Enter a new password below to change your password.</p>
                <div class="form-group">
                    <label for="inputPassword" class="fs-4 fw-medium">Password</label>
                    <input required type="password"
                        class="form-control @if ($errors->has('password')) {{ 'is-invalid' }} @endif" id="inputPassword"
                        placeholder="Enter new password" name="password" autocomplete="new-password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <label for="inputConfirmPassword" class="fs-4 fw-medium">Confirm New Password</label>
                    <input required type="password"
                        class="form-control @if ($errors->has('confirmPassword')) {{ 'is-invalid' }} @endif"
                        id="inputConfirmPassword" placeholder="Enter new password" name="confirmPassword"
                        autocomplete="new-password">
                    @if ($errors->has('confirmPassword'))
                        <div class="invalid-feedback">
                            {{ $errors->first('confirmPassword') }}
                        </div>
                    @endif
                </div>
                @if ($errors->has('error'))
                    <div class="alert alert-danger mt-2 mb-0">
                        {{ $errors->first('error') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary mt-3">Send Link</button>
                <a class="mx-auto my-3 text-primary text-decoration-none"
                    href="{{ route('admin.authentication.index') }}">Back to login</a>
            </form>
        </div>
    </div>
@endsection

@section('postloads')
@endsection
