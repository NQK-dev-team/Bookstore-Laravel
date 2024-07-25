<div class='w-100 h-100 d-flex'>
    <form class='bg-white border border-3 rounded m-auto px-3 pt-3 pb-5 d-flex flex-column cart-form'
        x-on:submit.prevent="async()=>{
            if(await $wire.purchase()===true)
            {
                const modal = new bootstrap.Modal('#purchaseModal');
                modal.toggle();
            }
            else
            {
                document.getElementById('error_message').innerHTML = 'The server cannot process your cart. Please try again.';
                const modal = new bootstrap.Modal('#errorModal');
                modal.toggle();
            }
        }"
        {{-- @alpine-submit="$wire.purchase()" --}} @alpine-toggle-stop-polling="$wire.toggleStopPolling();" @if (!$errors->any() && !$stopPolling)
        wire:poll.10s="$refresh"
        @endif id="pay_form">
        <h1 class='mt-2 fs-2'>Shopping Cart</h1>
        <hr>
        <div class='row flex-grow-1'>
            <div class='col-xl-8 col-12 d-flex flex-column'>
                <div class='flex-column d-flex'>
                    <h4>Ebooks</h4>
                    <div class="w-100 bg-white border rounded border-3 item-container mb-4">
                        @if ($cartDetail)
                            @foreach ($cartDetail->eBooks as $index => $book)
                                @php
                                    $discount = getBookBestDiscount($book);
                                @endphp
                                <div class='row m-2'>
                                    <div class='col-md-2 col-12 d-flex'>
                                        <a href="{{ route('customer.book.detail', ['id' => $book->id]) }}"
                                            class='m-auto' aria-label='Go to book detail page'>
                                            <img alt='{{ $book->name }} {{ $book->edition }} image'
                                                src="{{ $book->image }}" class='book_image'>
                                        </a>
                                    </div>
                                    <div class='col-md-4 col-12 d-flex'>
                                        <div
                                            class='d-flex flex-column justify-content-center my-0 my-md-auto mx-md-0 mx-auto pt-3'>
                                            <h5 class='fw-bold text-md-start text-center mb-0'>{{ $book->name }}</h5>
                                            <p class='text-md-start text-center mb-0'>{{ $book->edition }}</p>
                                            <div class='text-md-start text-center'>
                                                <p class='mb-0 text-nowrap'>
                                                    <span
                                                        class='{{ $book->fileCopy->price && $discount ? 'text-decoration-line-through' : 'fw-medium' }}'>${{ $book->fileCopy->price }}
                                                    </span>
                                                    @if ($book->fileCopy->price && $discount)
                                                        <span class='fw-medium ms-1'>
                                                            ${{ round(($book->fileCopy->price * (100.0 - $discount->discount)) / 100, 2) }}
                                                        </span>
                                                        <span class='text-danger'>
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                stroke="#ff0000">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                                </g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                    stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path
                                                                        d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
                                                                                    9.36039C4.2489 9.10039 4.4589 8.59038 4.4589 8.23038V6.08036C4.4589 5.20036 5.1789 4.48038
                                                                                    6.0589 4.48038H8.2089C8.5689 4.48038 9.0789 4.27041 9.3389 4.01041L10.8589 2.49039C11.4789
                                                                                    1.87039 12.4989 1.87039 13.1189 2.49039L14.6389 4.01041C14.8989 4.27041 15.4089 4.48038
                                                                                    15.7689 4.48038H17.9189C18.7989 4.48038 19.5189 5.20036 19.5189 6.08036V8.23038C19.5189
                                                                                    8.59038 19.7289 9.10039 19.9889 9.36039L21.5089 10.8804C22.1289 11.5004 22.1289 12.5204
                                                                                    21.5089 13.1404L19.9889 14.6604C19.7289 14.9204 19.5189 15.4304 19.5189
                                                                                    15.7904V17.9403C19.5189 18.8203 18.7989 19.5404 17.9189 19.5404H15.7689C15.4089 19.5404
                                                                                    14.8989 19.7504 14.6389 20.0104L13.1189 21.5304C12.4989 22.1504 11.4789 22.1504 10.8589
                                                                                    21.5304L9.3389 20.0104C9.0789 19.7504 8.5689 19.5404 8.2089 19.5404H6.0589C5.1789 19.5404
                                                                                    4.4589 18.8203 4.4589 17.9403V15.7904C4.4589 15.4204 4.2489 14.9104 3.9889 14.6604Z"
                                                                        stroke="#ff0000" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M9 15L15 9" stroke="#ff0000"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M14.4945 14.5H14.5035" stroke="#ff0000"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M9.49451 9.5H9.50349" stroke="#ff0000"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </g>
                                                            </svg>{{ $discount->discount }}%</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-12 d-flex mt-3 mt-md-0'>
                                        <div class='d-flex my-auto w-100'>
                                            <button class='bg-transparent border-0 ms-auto' type='button'
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                x-on:click="$wire.setDeleteID('{{ $book->id }}',2)">
                                                <i
                                                    class="bi bi-trash3-fill my-xl-auto trash-size pointer text-danger mx-xl-0 mx-auto"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if ($index < count($cartDetail->eBooks) - 1)
                                    <hr class='my-2'>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class='flex-column d-flex'>
                    <h4>Hardcovers</h4>
                    <div class='mb-2'>
                        <label class='fw-bold form-label' for="physicalDestination">Delivery Address:&nbsp;</label>
                        <input required
                            class='form-control border-3 {{ $errors->has('address') && $cartDetail && $cartDetail->physicalOrder ? 'is-invalid' : '' }}'
                            id="physicalDestination"
                            value="{{ $cartDetail && $cartDetail->physicalOrder ? $cartDetail->physicalOrder->address : '' }}"
                            x-on:change="$wire.updateAddress(event.target.value)">
                        @if ($errors->has('address') && $cartDetail && $cartDetail->physicalOrder)
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                    </div>
                    <div class="w-100 bg-white border rounded border-3 mb-4 item-container">
                        @if ($cartDetail)
                            @foreach ($cartDetail->hardCovers as $index => $book)
                                @php
                                    $discount = getBookBestDiscount($book);
                                    $stock = $this->getBookStock($book->id);
                                @endphp
                                <div class='row m-2'>
                                    <div class='col-md-2 col-12 d-flex'>
                                        <a href="{{ route('customer.book.detail', ['id' => $book->id]) }}"
                                            class='m-auto' aria-label='Go to book detail page'>
                                            <img alt='{{ $book->name }} {{ $book->edition }} image'
                                                src="{{ $book->image }}" class='book_image'>
                                        </a>
                                    </div>
                                    <div class='col-md-4 col-12 d-flex'>
                                        <div
                                            class='d-flex flex-column justify-content-center my-0 my-md-auto mx-md-0 mx-auto pt-3'>
                                            <h5 class='fw-bold text-md-start text-center mb-0'>{{ $book->name }}</h5>
                                            <p class='text-md-start text-center mb-0'>{{ $book->edition }}</p>
                                            <div class='text-md-start text-center'>
                                                <p class='mb-0 text-nowrap'>
                                                    <span
                                                        class='{{ $book->physicalCopy->price && $discount ? 'text-decoration-line-through' : 'fw-medium' }}'>${{ $book->physicalCopy->price }}
                                                    </span>
                                                    @if ($book->physicalCopy->price && $discount)
                                                        <span class='fw-medium ms-1'>
                                                            ${{ round(($book->physicalCopy->price * (100.0 - $discount->discount)) / 100, 2) }}
                                                        </span>
                                                        <span class='text-danger'>
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                stroke="#ff0000">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                                </g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                    stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path
                                                                        d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
                                                                                    9.36039C4.2489 9.10039 4.4589 8.59038 4.4589 8.23038V6.08036C4.4589 5.20036 5.1789 4.48038
                                                                                    6.0589 4.48038H8.2089C8.5689 4.48038 9.0789 4.27041 9.3389 4.01041L10.8589 2.49039C11.4789
                                                                                    1.87039 12.4989 1.87039 13.1189 2.49039L14.6389 4.01041C14.8989 4.27041 15.4089 4.48038
                                                                                    15.7689 4.48038H17.9189C18.7989 4.48038 19.5189 5.20036 19.5189 6.08036V8.23038C19.5189
                                                                                    8.59038 19.7289 9.10039 19.9889 9.36039L21.5089 10.8804C22.1289 11.5004 22.1289 12.5204
                                                                                    21.5089 13.1404L19.9889 14.6604C19.7289 14.9204 19.5189 15.4304 19.5189
                                                                                    15.7904V17.9403C19.5189 18.8203 18.7989 19.5404 17.9189 19.5404H15.7689C15.4089 19.5404
                                                                                    14.8989 19.7504 14.6389 20.0104L13.1189 21.5304C12.4989 22.1504 11.4789 22.1504 10.8589
                                                                                    21.5304L9.3389 20.0104C9.0789 19.7504 8.5689 19.5404 8.2089 19.5404H6.0589C5.1789 19.5404
                                                                                    4.4589 18.8203 4.4589 17.9403V15.7904C4.4589 15.4204 4.2489 14.9104 3.9889 14.6604Z"
                                                                        stroke="#ff0000" stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M9 15L15 9" stroke="#ff0000"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M14.4945 14.5H14.5035" stroke="#ff0000"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path d="M9.49451 9.5H9.50349" stroke="#ff0000"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </g>
                                                            </svg>{{ $discount->discount }}%</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-12 d-flex mt-3 mt-md-0 position-relative'>
                                        <div class='d-flex flex-column flex-sm-row my-auto w-100'>
                                            <div class='flex-grow-1 d-flex flex-column'>
                                                <div class='d-flex mx-auto'>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <input aria-label='Decrease amount' type="button"
                                                            class="btn-check"
                                                            id="decrease_book_ammount_{{ $book->id }}"
                                                            autocomplete="off"
                                                            onclick="decrease('{{ $book->id }}')">
                                                        <label class="btn btn-secondary"
                                                            for="decrease_book_ammount_{{ $book->id }}">-</label>

                                                        <input required type="number"
                                                            class="fw-bold ammount_input ps-2 border-2 border-secondary"
                                                            id="book_ammount_{{ $book->id }}" autocomplete="off"
                                                            value="{{ getAmount($cartDetail->id, $book->id) }}"
                                                            min="1" max="{{ $stock }}"
                                                            x-on:change="const value=amountChange('{{ $book->id }}');
                                                    $wire.updateAmount('{{ $book->id }}',value);">

                                                        <input aria-label='Increase amount' type="button"
                                                            class="btn-check"
                                                            id="increase_book_ammount_{{ $book->id }}"
                                                            autocomplete="off"
                                                            onclick="increase('{{ $book->id }}')">
                                                        <label class="btn btn-secondary"
                                                            for="increase_book_ammount_{{ $book->id }}">+</label>
                                                    </div>
                                                    <div class='d-flex align-items-center ms-2'>
                                                        <strong class='text-nowrap'>In stock:&nbsp;</strong>
                                                        <strong>{{ $stock }}</strong>
                                                    </div>
                                                </div>
                                                @if ($errors->has("{$book->id}_amount"))
                                                    <div class="text-danger text-center">
                                                        {{ $errors->first("{$book->id}_amount") }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class='absolute-trash'>
                                                <button class='bg-transparent border-0' type='button'
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    x-on:click="$wire.setDeleteID('{{ $book->id }}',1)">
                                                    <i
                                                        class="bi bi-trash3-fill my-xl-auto trash-size pointer text-danger mx-xl-0 mx-auto"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($index < count($cartDetail->hardCovers) - 1)
                                    <hr class='my-2'>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-xl-4 col-12 mt-3 mt-xl-0'>
                <h4>Price Detail</h4>
                <div class='border border-3 rounded py-2 px-3 mb-5'>
                    <p>Total Before Discount Coupons:&nbsp;<span
                            class='fw-medium'>{{ $cartDetail ? '$' . $cartDetail->total_discount + $cartDetail->total_price : 0 }}</span>
                    </p>
                    <p>Total After Discount Coupons:&nbsp;<span class='fw-medium'>
                            @php
                                $result = $cartDetail ? $cartDetail->total_price : 0;
                                $result = $loyalty ? round(($result * 100) / (100.0 - $loyalty), 2) : $result;
                                $result = $refer ? round(($result * 100) / (100.0 - $refer), 2) : $result;
                            @endphp
                            {{ $result }}
                        </span></p>
                    <p>Loyalty Discount:&nbsp;<span class='fw-medium'>{{ $loyalty ? $loyalty . '%' : 0 }}</span></p>
                    <p>Referrer Discount:&nbsp;<span class='fw-medium'>{{ $refer ? $refer . '%' : 0 }}</span></p>
                    <p>Total Discount:&nbsp;<span
                            class='fw-medium'>{{ $cartDetail ? '$' . $cartDetail->total_discount : 0 }}</span>
                    </p>
                    <h4>Final Price:&nbsp;<span
                            class='fw-medium'>{{ $cartDetail ? '$' . $cartDetail->total_price : 0 }}</span></h4>
                    <hr>
                    <button type="{{ $cartDetail ? 'submit' : 'button' }}"
                        class="btn btn-primary customized-button text-white mb-2 w-100 mt-3 fs-4"
                        {{ $cartDetail ? '' : 'data-bs-toggle=modal data-bs-target=#emptyModal' }}>Cash On
                        Delivery</button>
                    <div wire:ignore>
                        <div class='text-danger text-center mb-2 fw-medium'>ONLY USE SANDBOX ACCOUNTS FOR PAYPAL
                            PAYMENT!</div>
                        <div id='paypal_button_container'></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete From Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this book from your cart?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        x-on:click="$wire.deleteBook()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function increase(id) {
            const elem = document.getElementById(`book_ammount_${id}`);
            const stock = parseInt(elem.max);
            const value = parseInt(elem.value);

            if (value < stock) {
                elem.value = value + 1;
            }

            elem.dispatchEvent(new Event('change'));
        }

        function decrease(id) {
            const elem = document.getElementById(`book_ammount_${id}`);
            const value = parseInt(elem.value);

            if (value > 1) {
                elem.value = value - 1;
            }

            elem.dispatchEvent(new Event('change'));
        }

        function amountChange(id) {
            const elem = document.getElementById(`book_ammount_${id}`);
            const stock = parseInt(elem.max);
            const value = parseInt(elem.value);

            if (value < 1) {
                elem.value = 1;
            } else if (value > stock) {
                elem.value = stock;
            }
            return elem.value;
        }
    </script>
</div>
