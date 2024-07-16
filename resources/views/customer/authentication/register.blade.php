@extends('components.layouts.customer')

@section('preloads')
    <title>Register</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Register new NQK bookstore account">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            <form action="" method="POST"
                class="bg-white border border-black rounded form my-auto d-flex flex-column px-3">
                @csrf
                <input name="user_type" type="hidden" value="customer">
                <div class='w-100 d-flex flex-column'>
                    <h1 class="text-center mb-0 mt-3">Register</h1>
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
                    <div class='d-flex'>
                        <label for="inputName" class="fs-4 fw-medium">Name</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <input required id="inputName" type="text"
                        class="form-control @if ($errors->has('name')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter name" name="name" autocomplete="name" value="{{ session('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class='d-flex'>
                        <label for="inputDoB" class="fs-4 fw-medium">Date of Birth</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <input required id="inputDoB" type="date"
                        class="form-control @if ($errors->has('dob')) {{ 'is-invalid' }} @endif" name="dob"
                        value="{{ session('dob') }}">
                    @if ($errors->has('dob'))
                        <div class="invalid-feedback">
                            {{ $errors->first('dob') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class='d-flex'>
                        <label for="inputGender" class="fs-4 fw-medium">Gender</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <select name="gender" class="form-select @if ($errors->has('gender')) {{ 'is-invalid' }} @endif"
                        aria-label="Select gender" id="inputGender">
                        <option {{ session('gender') ? '' : 'selected' }} value="">Choose your gender</option>
                        <option {{ session('gender') === 'M' ? 'selected' : '' }} value="M">Male</option>
                        <option {{ session('gender') === 'F' ? 'selected' : '' }} value="F">Female</option>
                        <option {{ session('gender') === 'O' ? 'selected' : '' }} value="O">Other</option>
                    </select>
                    @if ($errors->has('gender'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class='d-flex'>
                        <label for="inputPhone" class="fs-4 fw-medium">Phone Number</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <input required id="inputPhone" type="tel" maxlength="10"
                        class="form-control @if ($errors->has('phone')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter phone number" name="phone" autocomplete="tel" value="{{ session('phone') }}">
                    @if ($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <label for="inputAddress" class="fs-4 fw-medium">Address</label>
                    <input required id="inputAddress" type="text"
                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" placeholder="Enter address"
                        name="address" autocomplete="off" value="{{ session('address') }}">
                    @if ($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class='d-flex'>
                        <label for="inputEmail" class="fs-4 fw-medium">Email</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
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
                    <div class='d-flex'>
                        <label for="inputPassword" class="fs-4 fw-medium">Password</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <input required id="inputPassword" autocomplete="new-password" type="password"
                        class="form-control @if ($errors->has('password')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter password" name="password" value="{{ session('password') }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <div class='d-flex'>
                        <label for="inputConfirmPassword" class="fs-4 fw-medium">Confirm Password</label>
                        <p class="text-danger mb-0 ms-1 align-middle text-center fs-4 fw-bold">*</p>
                    </div>
                    <input required id="inputConfirmPassword" autocomplete="new-password" type="password"
                        class="form-control @if ($errors->has('confirmPassword')) {{ 'is-invalid' }} @endif"
                        placeholder="Confirm password" name="confirmPassword" value="{{ session('confirmPassword') }}">
                    @if ($errors->has('confirmPassword'))
                        <div class="invalid-feedback">
                            {{ $errors->first('confirmPassword') }}
                        </div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <label for="inputRefEmail" class="fs-4 fw-medium">Referral Email</label>
                    <input id="inputRefEmail" autocomplete="email" type="email"
                        class="form-control @if ($errors->has('refEmail')) {{ 'is-invalid' }} @endif"
                        placeholder="Enter referral email" name="refEmail" value="{{ session('refEmail') }}">
                    @if ($errors->has('refEmail'))
                        <div class="invalid-feedback">
                            {{ $errors->first('refEmail') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                <p class='text-center mt-3'>Already have an account? <a
                        class="mx-auto mt-2 text-primary text-decoration-none mb-2"
                        href="{{ route('customer.authentication.index') }}">Sign in</a></p>
            </form>
        </div>
    </div>
@endsection

@section('postloads')
@endsection
