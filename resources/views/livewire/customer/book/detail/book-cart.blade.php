<form class='mt-3' x-data="{ radioOption: 0, }" wire:submit="addToCart(radioOption)">
    <div>
        @if ($physicalPrice !== null && $stock !== null)
            <input type="radio" id="hardcover" name="bookType" class="btn-check" autocomplete="off"
                x-on:click="radioOption=1;">
            <label class="btn border border-1 border-dark" for="hardcover">Hardcover</label>
        @endif

        @if ($filePrice !== null)
            <input type="radio" class="btn-check" name="bookType" id="ebook" autocomplete="off"
                x-on:click="radioOption=2;">
            <label
                class="btn border border-1 border-dark {{ $physicalPrice !== null && $stock !== null ? 'ms-3' : '' }}"
                for="ebook">Ebook</label>
        @endif
    </div>

    @if ($filePrice !== null)
        <div x-show="radioOption===2">
            <h5 class='mt-3 align-items-center mb-0 d-flex'>
                <span class='fw-normal'>Price:</span><span
                    class='ms-2 {{ $discount ? 'text-decoration-line-through' : '' }}'>${{ $filePrice }}</span>
                @if ($discount)
                    <span class='ms-2'>${{ round(($filePrice * (100.0 - $discount)) / 100, 2) }}</span>
                    <svg class='ms-2' width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
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
                                stroke="#ff0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M14.4945 14.5H14.5035" stroke="#ff0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M9.49451 9.5H9.50349" stroke="#ff0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg><span class='text-danger'>{{ $discount }}%</span>
                @endif
            </h5>
        </div>
    @endif


    @if ($physicalPrice !== null && $stock !== null)
        <div x-show="radioOption===1">
            <h5 class='mt-3 align-items-center mb-0 d-flex'>
                <span class='fw-normal'>Price:</span><span
                    class='ms-2 {{ $discount ? 'text-decoration-line-through' : '' }}'>${{ $physicalPrice }}</span>
                @if ($discount)
                    <span class='ms-2'>${{ round(($physicalPrice * (100.0 - $discount)) / 100, 2) }}</span>
                    <svg class='ms-2' width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
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
                                stroke="#ff0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M14.4945 14.5H14.5035" stroke="#ff0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M9.49451 9.5H9.50349" stroke="#ff0000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg><span class='text-danger'>{{ $discount }}%</span>
                @endif
            </h5>
        </div>
    @endif


    @if ($physicalPrice !== null && $stock !== null)
        <div x-show="radioOption===1">
            <div class='mt-3 align-items-center d-flex'>
                <div class="btn-group" role="group">
                    <input aria-label='Decrease amount' wire:click="decreaseAmount()" type="button" class="btn-check"
                        id="decrease_book_ammount" autocomplete="off" {{ $quantity <= 1 ? 'disabled' : '' }}>
                    <label class="btn btn-sm btn-secondary fs-6" for="decrease_book_ammount">-</label>

                    <input type="number" class="fw-bold ammount_input ps-2 border-1 border-secondary"
                        id="book_ammount" x-on:change="$wire.checkAmount()" wire:model.live="quantity"
                        autocomplete="off" {{ $stock ? 'min="1"' : '' }} max="{{ $stock ? $stock : 0 }}">

                    <input aria-label='Increase amount' wire:click="increaseAmount()" type="button"
                        class="btn-check" id="increase_book_ammount" autocomplete="off"
                        {{ $quantity >= $stock ? 'disabled' : '' }}>
                    <label class="btn btn-sm btn-secondary fs-6" for="increase_book_ammount">+</label>
                </div>
                <p class='mb-0 ms-3'>In stock: <strong
                        wire:poll.visible.5s.keep-alive="refetchStock">{{ $stock ? $stock : 0 }}</strong></p>
            </div>
        </div>
    @endif

    @if (($physicalPrice !== null && $stock !== null) || $filePrice !== null)
        @if (auth()->check())
            <button type='submit' class='btn btn-primary mt-3' x-bind:disabled="radioOption === 0">
                <i class='bi bi-cart4'></i>
                Add to cart
            </button>
        @else
            <a href='{{ route('customer.authentication.index') }}' class='btn btn-primary mt-3'
                x-bind:class="radioOption === 0 ? 'disabled' : ''">
                <i class='bi bi-cart4'></i>
                Add to cart
            </a>
        @endif
    @else
        <h5 class='text-danger'>This book is not available.</h5>
    @endif
</form>
