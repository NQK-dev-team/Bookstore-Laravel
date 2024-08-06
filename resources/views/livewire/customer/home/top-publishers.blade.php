<div class='container-xl p-2 my-4 {{ count($topPublishers) ? 'd-block' : 'd-none' }}'>
    <div class='mx-3 bg-white rounded pb-3 d-flex flex-column'>
        <div class='mb-0 text-center p-3 d-flex justify-content-center align-items-center'>
            <h4><img alt='Icon' src='{{ asset('assets/images/stonk.png') }}' style="height:28px;width:28px;">
                &nbsp;Top Publishers
            </h4>
        </div>
        <div class='d-flex overflow-x-auto px-4 pb-2'>
            @foreach ($topPublishers as $publisher)
                <p class="mb-0 pointer ms-3 me-3 tab-hover text-nowrap {{ $selectedPublisher === $publisher ? 'tab-active' : '' }}"
                    wire:click="selectPublisher(`{{ $publisher }}`)">
                    {{ $publisher }}
                </p>
            @endforeach
        </div>
        <hr>
        <div class='container-xl px-0 position-relative'>
            <div class='w-100 h-100 position-absolute align-items-center justify-content-between side-navigate'
                id='topPublisherNavigate'>
                <div class='slide-button-div'>
                    <button aria-label="Left slide" id='topPublisherScrollLeft'
                        class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0 ms-1'>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" stroke="#828282" transform="rotate(180)">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                    fill="#828282"></path>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class='slide-button-div'>
                    <button aria-label="Right slide" id='topPublisherScrollRight'
                        class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0 me-1'>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" stroke="#828282">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                    fill="#828282"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <div class='mx-md-4 d-flex overflow-x-auto hideBrowserScrollbar smooth-scroll' id='topPublisherBookList'>
                @foreach ($books as $index => $book)
                    @if ($index === 0)
                        <a class='bg-white card px-3 py-2 text-decoration-none me-sm-3 me-2 ms-md-0 ms-2'
                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'>
                            <img class="card-img-top" src="{{ $book->image }}"
                                alt="{{ $book->name }} {{ $book->edition }} image">
                            <div class="card-body p-1 pt-2">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <p class="card-text">{{ $book->edition }}</p>
                                <p class="card-text">Author: {{ $book->authors }}</p>
                                @if ($book->discount)
                                    <span class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                @endif
                                <div class='d-flex mt-3'>
                                    <p class='text-nowrap'>Hardcover:</p>
                                    <p
                                        class='{{ $book->physicalCopy && $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->physicalCopy && $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->physicalCopy && $book->physicalCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                                <div class='d-flex'>
                                    <p class='text-nowrap'>E-book:</p>
                                    <p
                                        class='{{ $book->fileCopy && $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->fileCopy && $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->fileCopy && $book->fileCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @elseif ($index === count($books) - 1)
                        <a class='bg-white card px-3 py-2 text-decoration-none ms-sm-3 ms-2 me-md-0 me-2'
                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'>
                            <img class="card-img-top" src="{{ $book->image }}"
                                alt="{{ $book->name }} {{ $book->edition }} image">
                            <div class="card-body p-1 pt-2">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <p class="card-text">{{ $book->edition }}</p>
                                <p class="card-text">Author: {{ $book->authors }}</p>
                                @if ($book->discount)
                                    <span class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                @endif
                                <div class='d-flex mt-3'>
                                    <p class='text-nowrap'>Hardcover:</p>
                                    <p
                                        class='{{ $book->physicalCopy && $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->physicalCopy && $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->physicalCopy && $book->physicalCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                                <div class='d-flex'>
                                    <p class='text-nowrap'>E-book:</p>
                                    <p
                                        class='{{ $book->fileCopy && $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->fileCopy && $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->fileCopy && $book->fileCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @else
                        <a class='bg-white card px-3 py-2 text-decoration-none mx-sm-3 mx-2'
                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'>
                            <img class="card-img-top" src="{{ $book->image }}"
                                alt="{{ $book->name }} {{ $book->edition }} image">
                            <div class="card-body p-1 pt-2">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <p class="card-text">{{ $book->edition }}</p>
                                <p class="card-text">Author: {{ $book->authors }}</p>
                                @if ($book->discount)
                                    <span class='bg-danger p-1 rounded text-white'>-{{ $book->discount }}%</span>
                                @endif
                                <div class='d-flex mt-3'>
                                    <p class='text-nowrap'>Hardcover:</p>
                                    <p
                                        class='{{ $book->physicalCopy && $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->physicalCopy && $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->physicalCopy && $book->physicalCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                                <div class='d-flex'>
                                    <p class='text-nowrap'>E-book:</p>
                                    <p
                                        class='{{ $book->fileCopy && $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                        {{ $book->fileCopy && $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                    </p>
                                    @if ($book->fileCopy && $book->fileCopy->price && $book->discount)
                                        <p class='fw-medium'>
                                            ${{ round(($book->fileCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        <a class='btn moreBtn mx-auto mt-4' x-show="checkOverflow('topPublisherNavigate', 'topPublisherBookList');"
            x-init="addScrollEvent('topPublisherScrollLeft', 'topPublisherScrollRight', 'topPublisherBookList');"
            href="{{ route('customer.book.index', ['publisher' => $selectedPublisher]) }}">Browse More</a>
    </div>
</div>
