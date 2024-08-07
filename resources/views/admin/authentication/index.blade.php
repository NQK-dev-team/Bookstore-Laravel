@extends('components.layouts.admin')

@section('preloads')
    <title>Login</title>
    <meta name="author" content="Nghia Duong">
    <meta name="description" content="Login to NQK bookstore admin email account">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            <form action="" method="POST"
                class="bg-white border border-black rounded form my-auto d-flex flex-column px-3 needs-validation">
                @csrf
                <input name="user_type" type="hidden" value="admin">
                <div class='w-100 d-flex flex-column'>
                    <h1 class="text-center mb-0 mt-3">Login</h1>
                    <div
                        class="align-items-center justify-content-center error_message mt-3 @if ($errors->has('error_message')) {{ 'd-flex' }} @endif py-3">
                        <svg class="ms-1" fill="#ff0000" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                            stroke="#ff0000" stroke-width="30.72">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M520.741 163.801a10.234 10.234 0 00-3.406-3.406c-4.827-2.946-11.129-1.421-14.075 3.406L80.258 856.874a10.236 10.236 0 00-1.499 5.335c0 5.655 4.585 10.24 10.24 10.24h846.004c1.882 0 3.728-.519 5.335-1.499 4.827-2.946 6.352-9.248 3.406-14.075L520.742 163.802zm43.703-26.674L987.446 830.2c17.678 28.964 8.528 66.774-20.436 84.452a61.445 61.445 0 01-32.008 8.996H88.998c-33.932 0-61.44-27.508-61.44-61.44a61.445 61.445 0 018.996-32.008l423.002-693.073c17.678-28.964 55.488-38.113 84.452-20.436a61.438 61.438 0 0120.436 20.436zM512 778.24c22.622 0 40.96-18.338 40.96-40.96s-18.338-40.96-40.96-40.96-40.96 18.338-40.96 40.96 18.338 40.96 40.96 40.96zm0-440.32c-22.622 0-40.96 18.338-40.96 40.96v225.28c0 22.622 18.338 40.96 40.96 40.96s40.96-18.338 40.96-40.96V378.88c0-22.622-18.338-40.96-40.96-40.96z">
                                </path>
                            </g>
                        </svg>
                        <p class="mb-0 text-danger fw-medium ms-2 me-1">
                            @if ($errors->has('error_message'))
                                {{ $errors->first('error_message') }}
                            @endif
                        </p>
                    </div>
                    <hr>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="fs-4 fw-medium">Email</label>
                    <input required id="inputEmail" type="email"
                        class="form-control @if ($errors->has('email')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter email" name="email" autocomplete="email" value="{{ session('email') }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <label for="inputPassword" class="fs-4 fw-medium">Password</label>
                    <input required id="inputPassword" autocomplete="current-password" type="password"
                        class="form-control @if ($errors->has('password')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter password" name="password" value="{{ session('password') }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
                <a class="mx-auto mt-3 text-primary text-decoration-none mb-2"
                    href="{{ route('admin.authentication.recovery') }}">Forgot password?</a>
            </form>

        </div>
    </div>
@endsection

@section('postloads')
@endsection
