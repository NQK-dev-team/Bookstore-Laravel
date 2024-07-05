@extends('components.layouts.customer')

@section('preloads')
    <title>Home</title>
    <meta name="author" content="Nghia Duong">
    <meta name="description" content="Home page of NQK bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/home/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    <div class='w-100 d-flex flex-column'>
        <div class='w-100 sales'>
            <div class='container-lg p-2'>
                <div class='mx-3 bg-white rounded mt-3 py-2 px-2 px-sm-3 d-flex align-items-center'>
                    <img alt='Icon' src='{{ asset('assets/images/flash_sale.png') }}' class='flash_sale_image'>
                    <a aria-label="view more discounted books"
                        href='{{ route('customer.book.index', ['select' => 'discount']) }}'
                        class='text-decoration-none ms-auto fs-5 d-flex align-items-center'>More<svg width="24px"
                            height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                    fill="#007bff"></path>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
            <div class='container-lg p-2 my-3 position-relative'>
                <div class='w-100 h-100 position-absolute align-items-center justify-content-between pe-3'
                    id='slideNavigate'>
                    <div class='slide-button-div'>
                        <button aria-label="Left slide" id='slideLeft'
                            class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0'>
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
                        <button aria-label="Right slide" id='slideRight'
                            class='slide-button btn btn-outline-secondary bg-white rounded-circle p-0'>
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
                <div class='mx-3 d-flex overflow-x-auto hideBrowserScrollbar' id='saleList'>
                    {{-- Code here --}}
                </div>
            </div>
        </div>
        <div class='container-lg p-2 mt-4'>
            <div class='mx-3'>
                <h4 class='text-white mb-0 text-center banner p-3 rounded-top'>Best Sellers</h4>
                <div class='bg-white row mx-0 rounded-bottom'>
                    <div class='col-12 col-lg-5 select-border my-3 pe-0'>
                        {{-- Code here --}}
                    </div>
                    <div class='col-lg-7 d-lg-block d-none py-3'>
                        {{-- Code here --}}
                    </div>
                </div>
                <div class='bg-white d-flex pb-3'>
                    <a class='btn moreBtn mx-auto' href='{{ route('customer.book.index', ['select' => 'sales']) }}'>Browse
                        More</a>
                </div>
            </div>
        </div>
        <div class='container-lg p-2 my-4'>
            <div class='mx-3 bg-white rounded pb-3 d-flex flex-column'>
                <div class='mb-0 text-center p-3 d-flex justify-content-center align-items-center'>
                    <h4><svg width="28px" height="28px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path opacity="0.34"
                                    d="M5 10H7C9 10 10 9 10 7V5C10 3 9 2 7 2H5C3 2 2 3 2 5V7C2 9 3 10 5 10Z"
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
                @livewire('customer.home.category')
                <hr>
                <div class='container-lg px-0 position-relative'>
                    <div class='w-100 h-100 position-absolute align-items-center justify-content-between'
                        id='slideNavigate2'>
                        <div class='slide-button-div'>
                            <button aria-label="Left slide" id='slideLeft2'
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
                            <button aria-label="Right slide" id='slideRight2'
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
                    <div class='mx-md-4 d-flex overflow-x-auto hideBrowserScrollbar' id='bookList1'>
                        {{-- Code here --}}
                    </div>
                </div>
                <button class='btn moreBtn mx-auto mt-4' onclick="viewMoreCategoryBook()">Browse More</button>
            </div>
        </div>
        <div class='container-lg p-2 my-4'>
            <div class='mx-3 bg-white rounded pb-3 d-flex flex-column'>
                <div class='mb-0 text-center p-3 d-flex justify-content-center align-items-center'>
                    <h4><img alt='Icon' src='{{ asset('assets/images/stonk.png') }}'
                            style="height:28px;width:28px;">&nbsp;Top Publishers
                    </h4>
                </div>
                @livewire('customer.home.publisher')
                <hr>
                <div class='container-lg px-0 position-relative'>
                    <div class='w-100 h-100 position-absolute align-items-center justify-content-between'
                        id='slideNavigate1'>
                        <div class='slide-button-div'>
                            <button aria-label="Left slide" id='slideLeft1'
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
                            <button aria-label="Right slide" id='slideRight1'
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
                    <div class='mx-md-4 d-flex overflow-x-auto hideBrowserScrollbar' id='bookList'>
                        {{-- Code here --}}
                    </div>
                </div>
                <button class='btn moreBtn mx-auto mt-4' onclick="viewMorePublisherBook()">Browse More</button>
            </div>
        </div>
        {{-- <div class=" modal fade" id="errorModal" tabindex="-1" aria-labelledby="Error modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5">Error!</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <p id="error_message"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script></script>
@endsection
