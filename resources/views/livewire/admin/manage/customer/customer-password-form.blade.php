<form class='d-flex flex-column flex-grow-1 needs-validation' wire:submit="updatePassword();" x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`);
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));">
    <div class='flex-column w-100 d-flex mb-5'>
        <label for="email" class='d-none'>Email</label>
        <input type="email" autocomplete="email" id="email" value="{{ $email }}" disabled readonly
            class='d-none'>
        <div class="my-2">
            <label for="newPasswordInput" class="form-label fw-medium">New Password:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <input required name="newPassword" type="password"
                class="form-control {{ $errors->has('newPassword') ? 'is-invalid' : '' }}" id="newPasswordInput"
                placeholder="Enter new password" autocomplete="new-password" wire:model="newPassword"
                data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="New password must contain at least one uppercase letter, one lowercase letter, one number, one special character and is at least 8 characters long.">
            @if ($errors->has('newPassword'))
                <div class="invalid-feedback">
                    {{ $errors->first('newPassword') }}
                </div>
            @endif
        </div>
        <div class="my-2">
            <label for="confirmPasswordInput" class="form-label fw-medium">Confirm New
                Password:<span class='fw-bold text-danger'>&nbsp;*</span></label>
            <input required name="confirmPassword" type="password"
                class="form-control {{ $errors->has('confirmPassword') ? 'is-invalid' : '' }}"
                wire:model="confirmPassword" id="confirmPasswordInput" placeholder="Confirm new password"
                autocomplete="new-password">
            @if ($errors->has('confirmPassword'))
                <div class="invalid-feedback">
                    {{ $errors->first('confirmPassword') }}
                </div>
            @endif
        </div>
    </div>
    <hr class='mt-auto'>
    <div class='d-flex justify-content-end'>
        <button class='btn btn-secondary me-2' type='button' x-on:click="$wire.clearErrorBag();">Reset</button>
        <button class='btn btn-primary ms-2' type='submit'>Save</button>
    </div>
</form>
