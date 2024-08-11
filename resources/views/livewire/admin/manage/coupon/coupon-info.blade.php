<form class="modal-content" wire:submit="{{ $couponID ? ' updateCoupon()' : 'createCoupon()' }}">
    <div class="modal-header">
        <h2 class="modal-title fs-5">{{ $couponID ? 'Coupon Details' : 'Add New Coupon' }}</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_modal_btn"></button>
    </div>
    <div class="modal-body d-flex flex-column">
        <label class='form-label'>Coupon Name:<span class='fw-bold text-danger'>&nbsp;*</span></label>
        <input type="text" class='form-control {{ $errors->has('couponName') ? 'is-invalid' : '' }}' required
            wire:model="couponName">
        @if ($errors->has('couponName'))
            <div class="invalid-feedback">
                {{ $errors->first('couponName') }}
            </div>
        @endif
        <label class='form-label mt-3'>Discount Percentage (%):<span class='fw-bold text-danger'>&nbsp;*</span></label>
        <input class='form-control {{ $errors->has('couponDiscount') ? 'is-invalid' : '' }}' required type="number"
            min="0" max="100" wire:model="couponDiscount">
        @if ($errors->has('couponDiscount'))
            <div class="invalid-feedback">
                {{ $errors->first('couponDiscount') }}
            </div>
        @endif
        @if ((int) $couponType === 1)
            @php
                $minDateTime = (new DateTime('now'))
                    ->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')))
                    ->format('Y-m-d\TH:i');
            @endphp
            <label class='form-label mt-3'>Start Time:<span class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('startTime') ? 'is-invalid' : '' }}' required
                type="datetime-local" wire:model="startTime" min="{{ $minDateTime }}">
            @if ($errors->has('startTime'))
                <div class="invalid-feedback">
                    {{ $errors->first('startTime') }}
                </div>
            @endif
            <label class='form-label mt-3'>End Time:<span class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('endTime') ? 'is-invalid' : '' }}' required type="datetime-local"
                wire:model="endTime" min="{{ $minDateTime }}">
            @if ($errors->has('endTime'))
                <div class="invalid-feedback">
                    {{ $errors->first('endTime') }}
                </div>
            @endif
        @elseif((int) $couponType === 2)
            <label class='form-label mt-3'>Accumulated Points:<span class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('point') ? 'is-invalid' : '' }}' required type="number"
                min="0" wire:model="point">
            @if ($errors->has('point'))
                <div class="invalid-feedback">
                    {{ $errors->first('point') }}
                </div>
            @endif
        @elseif((int) $couponType === 3)
            <label class='form-label mt-3'>Number of People:<span class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('numberOfPeople') ? 'is-invalid' : '' }}' required
                type="number" min="0" wire:model="numberOfPeople">
            @if ($errors->has('numberOfPeople'))
                <div class="invalid-feedback">
                    {{ $errors->first('numberOfPeople') }}
                </div>
            @endif
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">{{ $couponID ? 'Update' : 'Add' }}</button>
    </div>
</form>
