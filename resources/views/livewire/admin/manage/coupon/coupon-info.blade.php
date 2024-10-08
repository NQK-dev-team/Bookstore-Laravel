<form class="modal-content" wire:submit="{{ $couponID ? ' updateCoupon()' : 'createCoupon()' }}">
    <div class="modal-header">
        <h2 class="modal-title fs-5">{{ $couponID ? 'Coupon Details' : 'Add New Coupon' }}</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_modal_btn"></button>
    </div>
    <div class="modal-body d-flex flex-column">
        <label class='form-label' for="coupon-name-input">Coupon Name:<span
                class='fw-bold text-danger'>&nbsp;*</span></label>
        <input type="text" class='form-control {{ $errors->has('couponName') ? 'is-invalid' : '' }}' required
            maxlength="255" wire:model="couponName" id="coupon-name-input">
        @if ($errors->has('couponName'))
            <div class="invalid-feedback">
                {{ $errors->first('couponName') }}
            </div>
        @endif
        <label class='form-label mt-3' for="coupon-discount-percentage">Discount Percentage (%):<span
                class='fw-bold text-danger'>&nbsp;*</span></label>
        <input class='form-control {{ $errors->has('couponDiscount') ? 'is-invalid' : '' }}' required type="number"
            min="0" max="100" wire:model="couponDiscount" id="coupon-discount-percentage">
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
            <label class='form-label mt-3' for="start-time">Start Time:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('startTime') ? 'is-invalid' : '' }}' required
                type="datetime-local"
                @if (!$couponID) wire:model="startTime" min="{{ $minDateTime }}" @endif
                id="start-time" step="1">
            @if ($errors->has('startTime'))
                <div class="invalid-feedback">
                    {{ $errors->first('startTime') }}
                </div>
            @endif
            <label class='form-label mt-3' for="end-time">End Time:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('endTime') ? 'is-invalid' : '' }}' required type="datetime-local"
                wire:model="endTime" @if (!$couponID) min="{{ $minDateTime }}" @endif id="end-time"
                step="1">
            @if ($errors->has('endTime'))
                <div class="invalid-feedback">
                    {{ $errors->first('endTime') }}
                </div>
            @endif
            <label class='form-label mt-3' for="books-applied">Books Applied:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="selectAllSwitch" wire:model="all"
                    x-on:change="if($el.checked){
                        document.getElementById('books-applied').disabled = true;
                        document.getElementById('books-applied').classList.remove('pointer');
                        document.getElementById('books-applied').removeEventListener('click', function(e){
                            new bootstrap.Modal(document.getElementById('bookListModal')).toggle();
                        });
                        $wire.booksDisplayed='';
                        $wire.$refresh();
                    }else{
                        document.getElementById('books-applied').disabled = false;
                        document.getElementById('books-applied').classList.add('pointer');
                        document.getElementById('books-applied').addEventListener('click', function(e){
                            new bootstrap.Modal(document.getElementById('bookListModal')).toggle();
                        });
                        $wire.displayBooks();
                    }">
                <label class="form-check-label" for="selectAllSwitch" wire:model="all">All Books</label>
            </div>
            <textarea rows="5" id="books-applied" class="form-control readonly {{ $all ? '' : 'pointer' }}"
                @if ($all) disabled
                @else onclick="new bootstrap.Modal(document.getElementById('bookListModal')).toggle();" @endif
                style="caret-color: transparent;" wire:model="booksDisplayed"></textarea>
            <label for="email-template" class="form-label mt-3">Email Template</label>
            <input
                class="form-control form-control-sm {{ $errors->has('emails') || $errors->has('emails.0') ? 'is-invalid' : '' }}"
                id="email-template" type="file" wire:model="emails"
                accept="{{ env('HTML_ACCEPT_EMAIL_TEMPLATE', '.htm,.html') }}" wire:key="{{ $inputFileKey }}">
            @if ($errors->has('emails'))
                <div class="invalid-feedback">
                    {{ $errors->first('emails') }}
                </div>
            @endif
            @if ($errors->has('emails.0'))
                <div class="invalid-feedback">
                    {{ $errors->first('emails.0') }}
                </div>
            @endif
        @elseif((int) $couponType === 2)
            <label class='form-label mt-3' for="points">Accumulated Points:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('point') ? 'is-invalid' : '' }}' required type="number"
                min="0" wire:model="point" id="points">
            @if ($errors->has('point'))
                <div class="invalid-feedback">
                    {{ $errors->first('point') }}
                </div>
            @endif
        @elseif((int) $couponType === 3)
            <label class='form-label mt-3' for="NoP">Number of People:<span
                    class='fw-bold text-danger'>&nbsp;*</span></label>
            <input class='form-control {{ $errors->has('numberOfPeople') ? 'is-invalid' : '' }}' required
                type="number" min="0" wire:model="numberOfPeople" id="NoP">
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
    <script>
        document.querySelectorAll('.readonly').forEach(element => {
            element.addEventListener('keydown', function(e) {
                if (e.keyCode !== 9) { // ignore tab
                    e.preventDefault();
                }
            });

            element.addEventListener('paste', function(e) {
                e.preventDefault();
            });

            element.addEventListener('focus', function(e) {
                e.preventDefault();
            });

            element.addEventListener('mousedown', function(e) {
                e.preventDefault();
            });
        });
    </script>
</form>
