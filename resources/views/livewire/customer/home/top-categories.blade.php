 <div class='container-xl p-2 my-4 {{ count($topCategories) ? 'd-block' : 'd-none' }}' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
 const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
     tooltipTriggerEl))">
     <div class='mx-3 bg-white rounded pb-3 d-flex flex-column'>
         <div class='mb-0 text-center p-3 d-flex justify-content-center align-items-center'>
             <h4><svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                     <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                     <g id="SVGRepo_iconCarrier">
                         <path opacity="0.34" d="M5 10H7C9 10 10 9 10 7V5C10 3 9 2 7 2H5C3 2 2 3 2 5V7C2 9 3 10 5 10Z"
                             stroke="#ff0000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                             stroke-linejoin="round"></path>
                         <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z"
                             stroke="#ff0000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                             stroke-linejoin="round"></path>
                         <path opacity="0.34"
                             d="M17 22H19C21 22 22 21 22 19V17C22 15 21 14 19 14H17C15 14 14 15 14 17V19C14 21 15 22 17 22Z"
                             stroke="#ff0000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                             stroke-linejoin="round"></path>
                         <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z"
                             stroke="#ff0000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                             stroke-linejoin="round"></path>
                     </g>
                 </svg>&nbsp;Top Categories</h4>
         </div>
         <div class='d-flex overflow-x-auto px-4 pb-2'>
             @foreach ($topCategories as $category)
                 <p class="mb-0 pointer ms-3 me-3 tab-hover text-nowrap {{ $selectedCategory === $category ? 'tab-active' : '' }}"
                     wire:click="selectCategory(`{{ $category }}`)" data-bs-toggle="tooltip" data-bs-placement="top"
                     data-bs-title="{{ getCategoryDescription($category) }}">
                     {{ $category }}
                 </p>
             @endforeach
         </div>
         <hr>
         <div class='container-xl px-0 position-relative'>
             <div class='w-100 h-100 position-absolute align-items-center justify-content-between side-navigate'
                 id='topCategoryNavigate'>
                 <div class='slide-button-div'>
                     <button aria-label="Left slide" id='topCategoryScrollLeft'
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
                     <button aria-label="Right slide" id='topCategoryScrollRight'
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
             <div class='mx-md-4 d-flex overflow-x-auto hideBrowserScrollbar smooth-scroll' id='topCategoryBookList'>
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
                                         class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->physicalCopy->price && $book->discount)
                                         <p class='fw-medium'>
                                             ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                         </p>
                                     @endif
                                 </div>
                                 <div class='d-flex'>
                                     <p class='text-nowrap'>E-book:</p>
                                     <p
                                         class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->fileCopy->price && $book->discount)
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
                                         class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->physicalCopy->price && $book->discount)
                                         <p class='fw-medium'>
                                             ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                         </p>
                                     @endif
                                 </div>
                                 <div class='d-flex'>
                                     <p class='text-nowrap'>E-book:</p>
                                     <p
                                         class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->fileCopy->price && $book->discount)
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
                                         class='{{ $book->physicalCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->physicalCopy->price ? '$' . $book->physicalCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->physicalCopy->price && $book->discount)
                                         <p class='fw-medium'>
                                             ${{ round(($book->physicalCopy->price * (100.0 - $book->discount)) / 100, 2) }}
                                         </p>
                                     @endif
                                 </div>
                                 <div class='d-flex'>
                                     <p class='text-nowrap'>E-book:</p>
                                     <p
                                         class='{{ $book->fileCopy->price && $book->discount ? 'text-decoration-line-through' : '' }} mx-2 fw-medium'>
                                         {{ $book->fileCopy->price ? '$' . $book->fileCopy->price : 'N/A' }}
                                     </p>
                                     @if ($book->fileCopy->price && $book->discount)
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
         <a class='btn moreBtn mx-auto mt-4' x-show="checkOverflow('topCategoryNavigate', 'topCategoryBookList');"
             x-init="addScrollEvent('topCategoryScrollLeft', 'topCategoryScrollRight', 'topCategoryBookList');"
             href="{{ route('customer.book.index', ['category' => $selectedCategory]) }}">Browse
             More</a>
     </div>
 </div>
