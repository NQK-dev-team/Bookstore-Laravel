@extends('components.layouts.admin')

@section('preloads')
    <title>Recovery</title>
    <link rel="stylesheet" href="{{ asset('assets/css/authentication/style.css') }}">
@endsection

@section('page')
    <div class='w-100 h-100 position-relative'>
        <div class='background'></div>
        <div class="container-fluid h-100 d-flex justify-content-center py-4">
            {{-- <form class="bg-white border border-black rounded form my-auto flex-column px-3 d-flex" action=""
                method="POST">
                @csrf
                <input name="user_type" type="hidden" value="admin">
                <p class='mt-4'>Forgot your password? No problem. We will email you a password reset link that allow you to
                    set a new
                    one.</p>
                <div class="form-group">
                    <label for="inputEmail" class="fs-4 fw-medium">Email</label>
                    <input required type="email"
                        class="form-control @if ($errors->any()) {{ 'is-invalid' }} @endif" id="inputEmail"
                        placeholder="Enter email" name="email" autocomplete="email">
                    @if ($errors->any())
                        <div class="invalid-feedback">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Send Link</button>
                <a class="mx-auto my-3 text-primary text-decoration-none"
                    href="{{ route('admin.authentication.index') }}">Back to login</a>
            </form> --}}
        </div>
    </div>
@endsection

@section('postloads')
@endsection
