@extends('components.layouts.customer')

@section('preloads')
    <title>{{ auth()->user()->name }}</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Profile page of customers of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/profile/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class='d-flex w-100 h-100 flex-column' x-data="{ option: {{ $option ? $option : 1 }}, errorSignal: {{ $errors->has('images') || $errors->has('images.0') ? 1 : 0 }}, isInfoReset: 0, isPasswordReset: 0 }">
        <div class='block bg-white border border-3 rounded m-auto d-flex flex-column p-3'>
            <div>
                <h1 class='mb-3'>My account</h1>
                <div class='d-flex overflow-x-auto'>
                    <input type="radio" class='btn-check' id='select-personal-info' name='select-tab'
                        x-on:click="option=1">
                    <label for='select-personal-info' class="mb-2 pointer hover-tab text-nowrap"
                        :class="option === 1 ? 'selected' : ''">Personal
                        Information</label>
                    <input type="radio" class='btn-check' id='select-purchases' name='select-tab' x-on:click="option=2">
                    <label for='select-purchases' class="mb-2 ms-4 pointer hover-tab text-nowrap"
                        :class="option === 2 ? 'selected' : ''">Purchases</label>
                    <input type="radio" class='btn-check' id='select-password' name='select-tab' x-on:click="option=3">
                    <label for='select-password' class="mb-2 ms-4 pointer hover-tab text-nowrap"
                        :class="option === 3 ? 'selected' : ''">Change Password</label>
                    <input type="radio"p class='btn-check' id='select-other' name='select-tab' x-on:click="option=4">
                    <label for='select-other' class="mb-2 ms-4 me-1 pointer hover-tab text-nowrap"
                        :class="option === 4 ? 'selected' : ''">Other</label>
                </div>
            </div>
            <hr>
            <div x-show="option===1">
                <form class='d-flex flex-column flex-grow-1 needs-validation' enctype="multipart/form-data"
                    action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    <div class='w-100 flex-grow-1 row m-0'>
                        <div class="col-lg-5 col-12 p-0">
                            <div class='w-100 d-flex flex-column h-100 justify-content-center'>
                                <img class='custom_image w-100 mx-auto border-2 rounded'
                                    alt="{{ $errors->has('images') || $errors->has('images.0') ? 'Image too large' : auth()->user()->name . ' image' }}"
                                    id="userImage"
                                    src="{{ $errors->has('images') || $errors->has('images.0') ? '' : (auth()->user()->image ? route('temporary-url.image', ['path' => auth()->user()->image]) : asset('assets/images/default_profile_image.png')) }}"
                                    data-initial-src="{{ auth()->user()->image ? route('temporary-url.image', ['path' => auth()->user()->image]) : asset('assets/images/default_profile_image.png') }}"
                                    data-error-signal="{{ $errors->has('images') || $errors->has('images.0') ? 1 : 0 }}">
                                </img>
                                <label
                                    class='btn btn-sm btn-light border border-dark mt-3 mx-auto {{ $errors->has('images') || $errors->has('images.0') ? 'is-invalid' : '' }}'>
                                    <input accept='image/jpeg, image/png' id="imageInput" type='file' class='d-none'
                                        x-on:change="errorSignal=0;" name="images[]" onchange="setNewImage(event)"></input>
                                    Browse
                                </label>
                                @if ($errors->has('images'))
                                    <div class="invalid-feedback text-center" x-show="errorSignal === 1">
                                        {{ $errors->first('images') }}
                                    </div>
                                @endif
                                @if ($errors->has('images.0'))
                                    <div class="invalid-feedback text-center" x-show="errorSignal === 1">
                                        {{ $errors->first('images.0') }}
                                    </div>
                                @endif
                                <p id="imageFileName" class='mx-auto mt-2'></p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-12 p-0">
                            <div class='w-100 d-flex flex-column h-100'>
                                <div class="mt-auto mb-2 px-lg-5 px-3">
                                    <label for="nameInput" class="form-label fw-medium">Name:<span
                                            class='fw-bold text-danger'>&nbsp;*</span></label>
                                    <input required autocomplete="name" type="text" class="form-control" id="nameInput"
                                        @if ($errors->has('name')) x-bind:class="{ 'is-invalid': !isInfoReset }" @endif
                                        value="{{ old('name') ? old('name') : auth()->user()->name }}"
                                        data-old-value="{{ auth()->user()->name }}" name="name"
                                        placeholder="Enter name">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback" x-show="!isInfoReset">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="my-2 px-lg-5 px-3">
                                    <label for="emailInput" class="form-label fw-medium">Email:</label>
                                    <input required readonly autocomplete="email" type="email" class="form-control"
                                        id="emailInput" value="{{ auth()->user()->email }}" name="email" disabled
                                        placeholder="Enter email address">
                                </div>
                                <div class="my-2 px-lg-5 px-3">
                                    <label for="phoneInput" class="form-label fw-medium">Phone:<span
                                            class='fw-bold text-danger'>&nbsp;*</span></label>
                                    <input required maxlength="10" autocomplete="tel" type="tel" class="form-control"
                                        @if ($errors->has('phone')) x-bind:class="{ 'is-invalid': !isInfoReset }" @endif
                                        id="phoneInput" value="{{ old('phone') ? old('phone') : auth()->user()->phone }}"
                                        data-old-value="{{ auth()->user()->phone }}" name="phone"
                                        placeholder="Enter phone number">
                                    @if ($errors->has('phone'))
                                        <div class="invalid-feedback" x-show="!isInfoReset">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="my-2 px-lg-5 px-3">
                                    <label for="dobInput" class="form-label fw-medium">Date Of Birth:<span
                                            class='fw-bold text-danger'>&nbsp;*</span></label>
                                    <input required autocomplete="bday" type="date" class="form-control"
                                        id="dobInput"
                                        @if ($errors->has('dob')) x-bind:class="{ 'is-invalid': !isInfoReset }" @endif
                                        value="{{ old('dob') ? old('dob') : auth()->user()->dob }}"
                                        data-old-value="{{ auth()->user()->dob }}" name="dob">
                                    @if ($errors->has('dob'))
                                        <div class="invalid-feedback" x-show="!isInfoReset">
                                            {{ $errors->first('dob') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="my-2 px-lg-5 px-3">
                                    <label for="genderInput" class="form-label fw-medium">Gender:<span
                                            class='fw-bold text-danger'>&nbsp;*</span></label>
                                    <select required autocomplete="sex" class="form-select"
                                        @if ($errors->has('gender')) x-bind:class="{ 'is-invalid': !isInfoReset }" @endif
                                        aria-label="Select gender" id='genderInput'
                                        value="{{ old('gender') ? old('gender') : auth()->user()->gender }}"
                                        data-old-value="{{ auth()->user()->gender }}" name="gender">
                                        <option value="">Choose your gender</option>
                                        <option {{ auth()->user()->gender === 'M' ? 'selected' : '' }} value="M">Male
                                        </option>
                                        <option {{ auth()->user()->gender === 'F' ? 'selected' : '' }} value="F">
                                            Female</option>
                                        <option {{ auth()->user()->gender === 'O' ? 'selected' : '' }} value="O">
                                            Other
                                        </option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <div class="invalid-feedback" x-show="!isInfoReset">
                                            {{ $errors->first('gender') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-auto mt-2 px-lg-5 px-3">
                                    <label for="addressInput" class="form-label fw-medium">Address:<span
                                            class='fw-bold text-danger'>&nbsp;*</span></label>
                                    <input required autocomplete="off" type="text" class="form-control"
                                        @if ($errors->has('address')) x-bind:class="{ 'is-invalid': !isInfoReset }" @endif
                                        id="addressInput"
                                        value="{{ old('address') ? old('address') : auth()->user()->address }}"
                                        data-old-value="{{ auth()->user()->address }}" name="address"
                                        placeholder="Enter address">
                                    @if ($errors->has('address'))
                                        <div class="invalid-feedback" x-show="!isInfoReset">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='mt-5'></div>
                    <hr class='mt-auto'>
                    <div class='d-flex justify-content-end pb-4 mb-5 pb-lg-0'>
                        <button class='btn btn-secondary me-2' type='button'
                            x-on:click="setNewImage(null); errorSignal=0; resetInfoFields(); isInfoReset=1;">Reset</button>
                        <button class='btn btn-primary ms-2' type='submit'
                            x-bind:disabled="errorSignal === 1">Save</button>
                    </div>
                </form>
            </div>
            <div x-show="option===2">
                @livewire('customer.profile.order')
            </div>
            <div x-show="option===3">
                <form class='d-flex flex-column flex-grow-1 needs-validation'
                    action="{{ route('customer.profile.change-password') }}" method="POST">
                    @csrf
                    <div class='flex-column w-100 d-flex mb-5'>
                        <label for="email" class='d-none'>Email</label>
                        <input type="email" autocomplete="email" id="email" value="{{ auth()->user()->email }}"
                            disabled readonly class='d-none'>
                        <div class="my-2">
                            <label for="currentPasswordInput" class="form-label fw-medium">Current Password:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input required name="currentPassword" type="password" class="form-control"
                                @if ($errors->has('currentPassword')) x-bind:class="{ 'is-invalid': !isPasswordReset }" @endif
                                value="{{ old('currentPassword') }}" id="currentPasswordInput"
                                placeholder="Enter current password" autocomplete="current-password">
                            @if ($errors->has('currentPassword'))
                                <div class="invalid-feedback" x-show="!isPasswordReset">
                                    {{ $errors->first('currentPassword') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2">
                            <label for="newPasswordInput" class="form-label fw-medium">New Password:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input required name="newPassword" type="password" class="form-control"
                                @if ($errors->has('newPassword')) x-bind:class="{ 'is-invalid': !isPasswordReset }" @endif
                                id="newPasswordInput" placeholder="Enter new password" autocomplete="new-password"
                                value="{{ old('newPassword') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="New password must contain at least one uppercase letter, one lowercase letter, one number, one special character and is at least 8 characters long.">
                            @if ($errors->has('newPassword'))
                                <div class="invalid-feedback" x-show="!isPasswordReset">
                                    {{ $errors->first('newPassword') }}
                                </div>
                            @endif
                        </div>
                        <div class="my-2">
                            <label for="confirmPasswordInput" class="form-label fw-medium">Confirm New Password:<span
                                    class='fw-bold text-danger'>&nbsp;*</span></label>
                            <input required name="confirmPassword" type="password" class="form-control"
                                @if ($errors->has('confirmPassword')) x-bind:class="{ 'is-invalid': !isPasswordReset }" @endif
                                value="{{ old('confirmPassword') }}" id="confirmPasswordInput"
                                placeholder="Confirm new password" autocomplete="new-password">
                            @if ($errors->has('confirmPassword'))
                                <div class="invalid-feedback" x-show="!isPasswordReset">
                                    {{ $errors->first('confirmPassword') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr class='mt-auto'>
                    <div class='d-flex justify-content-end pb-4 mb-5 pb-lg-0'>
                        <button class='btn btn-secondary me-2' type='button'
                            x-on:click="isPasswordReset=1; resetPasswordFields();">Reset</button>
                        <button class='btn btn-primary ms-2' type='submit'>Save</button>
                    </div>
                </form>
            </div>
            <div x-show="option===4">
                <div class='mb-5'>
                    <p class='fw-medium mb-0'>Delete Account</p>
                    <p>(Your account will be deleted automatically after 14 days. Before this, you can login and the
                        process
                        will be cancelled)</p>
                    <button class='btn btn-sm btn-danger' data-bs-toggle="modal" data-bs-target="#deleteModal">Delete
                        Account</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="Delete account modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Confirm Deletion</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to delete your account?</p>
                </div>
                <form class="modal-footer" action="{{ route('customer.authentication.logout') }}" method="POST">
                    @csrf
                    <input type='hidden' name="is_delete_account_request" value={{ 1 }}>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoUpdateModal" tabindex="-1" aria-labelledby="Password changed modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Your information has been updated successfully.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordChangedModal" tabindex="-1" aria-labelledby="Password changed modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Your password has been changed successfully.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        function setNewImage(e) {
            const file = e ? e.target.files : [];
            document.getElementById('imageFileName').textContent = file.length === 1 ? file[0].name : '';
            newImg = file.length === 1 ? file[0] : null;

            if (file.length === 1) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('userImage').src = e.target.result;
                };

                reader.readAsDataURL(file[0]);
            } else
                document.getElementById('userImage').src = document.getElementById('userImage').getAttribute(
                    'data-initial-src');
        }

        // document.getElementById('passwordChangedModal').addEventListener('hidden.bs.modal', function() {
        //     document.getElementsByClassName('modal-backdrop')[0].remove();

        //     // Remove all styles and classes added by bootstrap in the body tag
        //     document.body.classList.remove('modal-open');
        //     document.body.style = '';
        // });

        if ({{ session('password-changed') ? session('password-changed') : 0 }}) {
            const successModal = new bootstrap.Modal('#passwordChangedModal');
            successModal.toggle();
        }

        if ({{ session('info-updated') ? session('info-updated') : 0 }}) {
            const successModal = new bootstrap.Modal('#infoUpdateModal');
            successModal.toggle();
        }
    </script>
    <script>
        function resetInfoFields() {
            const nameInput = document.getElementById('nameInput');
            const phoneInput = document.getElementById('phoneInput');
            const dobInput = document.getElementById('dobInput');
            const genderInput = document.getElementById('genderInput');
            const addressInput = document.getElementById('addressInput');

            nameInput.value = nameInput.getAttribute('data-old-value');
            phoneInput.value = phoneInput.getAttribute('data-old-value');
            dobInput.value = dobInput.getAttribute('data-old-value');
            genderInput.value = genderInput.getAttribute('data-old-value');
            addressInput.value = addressInput.getAttribute('data-old-value');
        }

        function resetPasswordFields() {
            const currentPasswordInput = document.getElementById('currentPasswordInput');
            const newPasswordInput = document.getElementById('newPasswordInput');
            const confirmPasswordInput = document.getElementById('confirmPasswordInput');

            currentPasswordInput.value = '';
            newPasswordInput.value = '';
            confirmPasswordInput.value = '';
        }
    </script>
@endsection
