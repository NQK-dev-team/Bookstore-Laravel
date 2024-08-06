<form class='d-flex flex-column flex-grow-1 needs-validation' wire:submit="saveInfo()">
    <div class='w-100 flex-grow-1 row m-0'>
        <div class="col-lg-5 col-12 p-0">
            <div class='w-100 d-flex flex-column h-100 justify-content-center'>
                <img class='custom_image w-100 mx-auto border-2 rounded' alt="{{ $name . ' image' }}"
                    src="{{ $image ? route('temporary-url.image', ['path' => $image]) : asset('assets/images/default_profile_image.png') }}">
                </img>
            </div>
        </div>
        <div class="col-lg-7 col-12 p-0">
            <div class='w-100 d-flex flex-column h-100'>
                <div class="mt-auto mb-2 px-lg-5 px-3">
                    <label for="nameInput" class="form-label fw-medium">Name:</label>
                    <input disabled autocomplete="name" type="text" class="form-control" id="nameInput"
                        value="{{ $name }}" name="name" placeholder="Enter name">
                </div>
                <div class="my-2 px-lg-5 px-3">
                    <label for="emailInput" class="form-label fw-medium">Email:<span
                            class='fw-bold text-danger'>&nbsp;*</span></label>
                    <input required autocomplete="email" type="email" class="form-control {{$errors->has('email')?'is-invalid':''}}"
                        id="emailInput" wire:model="email" name="email" placeholder="Enter email address">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="my-2 px-lg-5 px-3">
                    <label for="phoneInput" class="form-label fw-medium">Phone:</label>
                    <input disabled maxlength="10" minlength="10" autocomplete="tel" type="tel" class="form-control"
                        id="phoneInput" value="{{ $phone }}" pattern="[0-9]{10}" name="phone"
                        placeholder="Enter phone number">
                </div>
                <div class="my-2 px-lg-5 px-3">
                    <label for="dobInput" class="form-label fw-medium">Date Of Birth:</label>
                    <input disabled autocomplete="bday" type="date" class="form-control" id="dobInput"
                        value="{{ $dob }}" name="dob">
                </div>
                <div class="my-2 px-lg-5 px-3">
                    <label for="genderInput" class="form-label fw-medium">Gender:</label>
                    <select disabled autocomplete="sex" class="form-select" aria-label="Select gender" id='genderInput'
                        value="{{ $gender }}" name="gender">
                        <option value="">Choose your gender</option>
                        <option {{ $gender === 'M' ? 'selected' : '' }} value="M">Male
                        </option>
                        <option {{ $gender === 'F' ? 'selected' : '' }} value="F">
                            Female</option>
                        <option {{ $gender === 'O' ? 'selected' : '' }} value="O">
                            Other
                        </option>
                    </select>
                </div>
                <div class="mb-auto mt-2 px-lg-5 px-3">
                    <label for="addressInput" class="form-label fw-medium">Address:</label>
                    <input disabled autocomplete="off" type="text" class="form-control" id="addressInput"
                        value="{{ $address }}" name="address" placeholder="Enter address">
                </div>
            </div>
        </div>
    </div>
    <div class='mt-5'></div>
    <hr class='mt-auto'>
    <div class='d-flex justify-content-end'>
        <button class='btn btn-secondary me-2' type='button'
            x-on:click="$wire.resetForm();">Reset</button>
        <button class='btn btn-primary ms-2' type='submit'>Save</button>
    </div>
</form>
