<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    {{-- Bootstrap 5 CDN --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"
        integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Application CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    @yield('preloads')
</head>

<body>
    <section id="header">
        <header class="w-100 h-100">
            <nav class="navbar navbar-expand-lg py-auto w-100">
                <div class="container-fluid px-0">
                    <a class="navbar-brand d-flex align-items-center ms-2" href="{{ route('customer.home.index') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" id="logo_img"
                            title="NQK Bookstore logo"></img>
                        <p class="mb-0 ms-2">NQK Bookstore</p>
                    </a>
                    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse mt-2 mt-lg-0 me-lg-2 bg-white px-3"
                        id="navbarSupportedContent">
                        @php
                            $tab = request()->path();
                            $activeTab = '';
                            if (str_contains($tab, 'book')) {
                                $activeTab = 'book';
                            } elseif (str_contains($tab, 'cart')) {
                                $activeTab = 'cart';
                            } elseif (str_contains($tab, 'profile')) {
                                $activeTab = 'profile';
                            } elseif (str_contains($tab, 'authentication')) {
                                $activeTab = 'authentication';
                            } elseif (
                                !str_contains($tab, 'about-us') &&
                                !str_contains($tab, 'privacy-policy') &&
                                !str_contains($tab, 'terms-of-service') &&
                                !str_contains($tab, 'discount-program')
                            ) {
                                $activeTab = 'home';
                            }
                        @endphp
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item mx-2">
                                <a class="nav-link fs-5 d-inline-block {{ $activeTab === 'home' ? 'activeTab' : '' }}"
                                    href="{{ route('customer.home.index') }}">Home</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'book' ? 'activeTab' : '' }}"
                                    href="{{ route('customer.book.index') }}">Book</a>
                            </li>
                            <li class="nav-item mx-2">
                                @if (auth()->check())
                                    <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'cart' ? 'activeTab' : '' }}"
                                        href="{{ route('customer.cart.index') }}">Cart</a>
                                @else
                                    <a class="nav-link d-inline-block fs-5"
                                        href="{{ route('customer.authentication.index') }}">Cart</a>
                                @endif
                            </li>
                            @if (auth()->check())
                                <li class="nav-item ms-2">
                                    <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'profile' ? 'activeTab' : '' }}"
                                        href="{{ route('customer.profile.index') }}">Profile</a>
                                </li>
                                <li class="nav-item ms-2">
                                    <form id="logout-form" action="{{ route('customer.authentication.logout') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="nav-link d-inline-block fs-5 text-danger text-nowrap"
                                        href="{{ route('customer.authentication.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                        Out</a>
                                </li>
                            @else
                                <li class="nav-item ms-2">
                                    <a class="nav-link d-inline-block fs-5"
                                        href="{{ route('customer.authentication.index') }}">Profile</a>
                                </li>
                                <li class="nav-item ms-2">
                                    <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'authentication' ? 'activeTab' : '' }}"
                                        href="{{ route('customer.authentication.index') }}">Sign in</a>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </nav>
        </header>
    </section>
    <section id="page">
        @yield('page')
    </section>
    <section id="footer">
        <div class="container-fluid py-2 h-100">
            <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row h-100">
                <div class="text-center h-100 w-100 me-lg-3 d-flex flex-column my-2 my-lg-0">
                    <h3>About NQK Bookstore</h3>
                    <a href='{{ route('about-us') }}'>About Us</a>
                    <a href='{{ route('terms-of-service') }}'>Terms of Service</a>
                    <a href='{{ route('privacy-policy') }} '>Privacy Policy</a>
                    <a href='{{ route('discount-program') }} '>Discount Program</a>
                </div>
                <div class="text-center h-100 w-100 me-lg-3 my-2 my-lg-0">
                    <h3>Payment</h3>
                    <div class='d-flex flex-column'>
                        <div class='d-flex flex-column flex-sm-row align-items-center justify-content-center mb-1'>
                            <svg class='payment_method_footer rounded border border-1 border-white bg-white me-sm-1 mb-1 mb-sm-0'
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#"
                                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" version="1.1"
                                id="Layer_1" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 750 471"
                                enable-background="new 0 0 750 471" xml:space="preserve" sodipodi:docname="visa.svg"
                                inkscape:version="0.92.2 5c3e80d, 2017-08-06" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <defs id="defs4880"></defs>
                                    <title id="title4867">Slice 1</title>
                                    <desc id="desc4869">Created with Sketch.</desc>
                                    <g id="visa" sketch:type="MSLayerGroup">
                                        <path id="Shape" sketch:type="MSShapeGroup" fill="#0E4595"
                                            d="M278.198,334.228l33.36-195.763h53.358l-33.384,195.763H278.198 L278.198,334.228z">
                                        </path>
                                        <path id="path13" sketch:type="MSShapeGroup" fill="#0E4595"
                                            d="M524.307,142.687c-10.57-3.966-27.135-8.222-47.822-8.222 c-52.725,0-89.863,26.551-90.18,64.604c-0.297,28.129,26.514,43.821,46.754,53.185c20.77,9.597,27.752,15.716,27.652,24.283 c-0.133,13.123-16.586,19.116-31.924,19.116c-21.355,0-32.701-2.967-50.225-10.274l-6.877-3.112l-7.488,43.823 c12.463,5.466,35.508,10.199,59.438,10.445c56.09,0,92.502-26.248,92.916-66.884c0.199-22.27-14.016-39.216-44.801-53.188 c-18.65-9.056-30.072-15.099-29.951-24.269c0-8.137,9.668-16.838,30.559-16.838c17.447-0.271,30.088,3.534,39.936,7.5l4.781,2.259 L524.307,142.687">
                                        </path>
                                        <path id="Path" sketch:type="MSShapeGroup" fill="#0E4595"
                                            d="M661.615,138.464h-41.23c-12.773,0-22.332,3.486-27.941,16.234 l-79.244,179.402h56.031c0,0,9.16-24.121,11.232-29.418c6.123,0,60.555,0.084,68.336,0.084c1.596,6.854,6.492,29.334,6.492,29.334 h49.512L661.615,138.464L661.615,138.464z M596.198,264.872c4.414-11.279,21.26-54.724,21.26-54.724 c-0.314,0.521,4.381-11.334,7.074-18.684l3.607,16.878c0,0,10.217,46.729,12.352,56.527h-44.293V264.872L596.198,264.872z">
                                        </path>
                                        <path
                                            d="M 45.878906 138.46484 L 45.197266 142.53711 C 66.290228 147.64311 85.129273 155.0333 101.62305 164.22656 L 148.96875 333.91406 L 205.42383 333.85156 L 289.42773 138.46484 L 232.90234 138.46484 L 180.66406 271.96094 L 175.09961 244.83008 C 174.83893 243.99185 174.55554 243.15215 174.26562 242.31055 L 156.10547 154.99219 C 152.87647 142.59619 143.50892 138.89684 131.91992 138.46484 L 45.878906 138.46484 z "
                                            id="path16" style="fill:#0e4595;fill-opacity:1"></path>
                                    </g>
                                </g>
                            </svg>
                            <img title='Mastercard payment method' src='{{ asset('assets/images/mastercard.jpg') }}'
                                class='payment_method_footer rounded border bg-white ms-sm-1 mt-1 mt-sm-0'>
                        </div>
                        <div class='d-flex flex-column flex-sm-row align-items-center justify-content-center mt-1'>
                            <img title='American Express payment method' src='{{ asset('assets/images/AE.png') }}'
                                class='payment_method_footer rounded border border-1 border-white bg-white me-sm-1 mb-1 mb-sm-0'>
                            <svg class='payment_method_footer rounded border bg-white ms-sm-1 mt-1 mt-sm-0'
                                version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="64px" height="64px" viewBox="0 0 780 501"
                                enable-background="new 0 0 780 501" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>amex-outline</title>
                                    <desc>Created with Sketch.</desc>
                                    <g>
                                        <path fill="#003087"
                                            d="M168.379,169.853c-8.399-5.774-19.359-8.668-32.88-8.668H83.153c-4.145,0-6.435,2.073-6.87,6.215 L55.018,300.883c-0.221,1.311,0.107,2.51,0.981,3.6c0.869,1.092,1.962,1.635,3.271,1.635h24.864c4.361,0,6.758-2.068,7.198-6.215 l5.888-35.986c0.215-1.744,0.982-3.162,2.291-4.254c1.308-1.09,2.944-1.803,4.907-2.13c1.963-0.324,3.814-0.487,5.562-0.487 c1.743,0,3.814,0.11,6.217,0.327c2.397,0.218,3.925,0.324,4.58,0.324c18.756,0,33.478-5.285,44.167-15.866 c10.684-10.577,16.032-25.243,16.032-44.004C180.976,184.96,176.774,175.636,168.379,169.853z M141.389,209.933 c-1.094,7.635-3.926,12.649-8.506,15.049c-4.581,2.403-11.124,3.598-19.629,3.598l-10.797,0.327l5.563-35.007 c0.434-2.397,1.851-3.597,4.252-3.597h6.218c8.72,0,15.049,1.257,18.975,3.761C141.389,196.574,142.698,201.865,141.389,209.933z">
                                        </path>
                                        <path fill="#009CDE"
                                            d="M720.794,161.185h-24.208c-2.405,0-3.821,1.2-4.253,3.6l-21.267,136.099l-0.328,0.654 c0,1.096,0.437,2.127,1.311,3.109c0.868,0.98,1.963,1.471,3.27,1.471h21.595c4.138,0,6.429-2.068,6.871-6.215l21.265-133.813 v-0.325C725.049,162.712,723.627,161.185,720.794,161.185z">
                                        </path>
                                        <path fill="#003087"
                                            d="M428.31,213.856c0-1.088-0.439-2.126-1.306-3.106c-0.875-0.981-1.858-1.474-2.945-1.474h-25.192 c-2.404,0-4.366,1.096-5.889,3.271l-34.679,51.04l-14.395-49.075c-1.095-3.487-3.492-5.236-7.197-5.236h-24.541 c-1.093,0-2.074,0.492-2.941,1.474c-0.875,0.98-1.309,2.019-1.309,3.106c0,0.44,2.127,6.871,6.379,19.303 c4.252,12.435,8.832,25.849,13.74,40.245c4.908,14.393,7.469,22.031,7.688,22.898c-17.886,24.43-26.826,37.517-26.826,39.259 c0,2.838,1.416,4.254,4.253,4.254h25.192c2.398,0,4.36-1.088,5.889-3.27l83.427-120.399 C428.092,215.713,428.31,214.953,428.31,213.856z">
                                        </path>
                                        <path fill="#009CDE"
                                            d="M662.887,209.276h-24.866c-3.055,0-4.904,3.6-5.558,10.798c-5.677-8.721-16.031-13.088-31.083-13.088 c-15.704,0-29.066,5.89-40.077,17.668c-11.016,11.778-16.521,25.631-16.521,41.551c0,12.871,3.761,23.121,11.285,30.752 c7.525,7.639,17.612,11.451,30.266,11.451c6.323,0,12.757-1.311,19.3-3.926c6.544-2.617,11.665-6.105,15.379-10.469 c0,0.219-0.222,1.199-0.655,2.943c-0.44,1.748-0.655,3.059-0.655,3.926c0,3.494,1.414,5.234,4.254,5.234h22.576 c4.138,0,6.541-2.068,7.194-6.215l13.415-85.39c0.215-1.309-0.112-2.507-0.982-3.599 C665.284,209.823,664.196,209.276,662.887,209.276z M620.193,273.729c-5.562,5.453-12.268,8.178-20.12,8.178 c-6.328,0-11.449-1.742-15.377-5.234c-3.927-3.484-5.89-8.283-5.89-14.395c0-8.065,2.726-14.886,8.18-20.447 c5.447-5.562,12.214-8.343,20.285-8.343c6.101,0,11.173,1.8,15.212,5.397c4.032,3.6,6.054,8.563,6.054,14.889 C628.536,261.625,625.754,268.279,620.193,273.729z">
                                        </path>
                                        <path fill="#003087"
                                            d="M291.231,209.276h-24.865c-3.058,0-4.908,3.6-5.563,10.798c-5.889-8.721-16.25-13.088-31.081-13.088 c-15.704,0-29.065,5.89-40.078,17.668c-11.016,11.778-16.521,25.631-16.521,41.551c0,12.871,3.763,23.121,11.288,30.752 c7.525,7.639,17.61,11.451,30.262,11.451c6.104,0,12.433-1.311,18.975-3.926c6.543-2.617,11.778-6.105,15.704-10.469 c-0.875,2.617-1.309,4.908-1.309,6.869c0,3.494,1.417,5.234,4.253,5.234h22.574c4.141,0,6.543-2.068,7.198-6.215l13.413-85.39 c0.215-1.309-0.111-2.507-0.981-3.599C293.627,209.823,292.537,209.276,291.231,209.276z M248.535,273.891 c-5.563,5.35-12.382,8.016-20.447,8.016c-6.329,0-11.4-1.742-15.214-5.234c-3.819-3.484-5.726-8.283-5.726-14.395 c0-8.065,2.725-14.886,8.18-20.447c5.449-5.562,12.211-8.343,20.284-8.343c6.104,0,11.175,1.8,15.214,5.397 c4.032,3.6,6.052,8.563,6.052,14.889C256.878,261.844,254.097,268.553,248.535,273.891z">
                                        </path>
                                        <path fill="#009CDE"
                                            d="M540.036,169.853c-8.398-5.774-19.356-8.668-32.879-8.668h-52.019c-4.365,0-6.765,2.073-7.198,6.215 l-21.265,133.483c-0.221,1.311,0.106,2.51,0.981,3.6c0.866,1.092,1.962,1.635,3.271,1.635h26.826c2.617,0,4.361-1.416,5.235-4.252 l5.89-37.949c0.216-1.744,0.98-3.162,2.29-4.254c1.309-1.09,2.943-1.803,4.908-2.13c1.962-0.324,3.813-0.487,5.562-0.487 c1.743,0,3.814,0.11,6.214,0.327c2.399,0.218,3.93,0.324,4.58,0.324c18.759,0,33.479-5.285,44.168-15.866 c10.687-10.577,16.031-25.243,16.031-44.004C552.632,184.96,548.431,175.636,540.036,169.853z M506.502,223.673 c-4.799,3.271-11.997,4.906-21.592,4.906l-10.47,0.327l5.563-35.007c0.432-2.397,1.849-3.597,4.252-3.597h5.887 c4.797,0,8.614,0.218,11.454,0.653c2.831,0.439,5.561,1.799,8.178,4.089c2.619,2.29,3.926,5.618,3.926,9.979 C513.7,214.185,511.298,220.399,506.502,223.673z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="text-center h-100 w-100 me-lg-3 my-2 my-lg-0">
                    <h3>Shipping</h3>
                    <div class='d-flex flex-column'>
                        <div class='d-flex flex-column flex-sm-row align-items-center justify-content-center mb-1'>
                            <img title='DHL shipping service' src='{{ asset('assets/images/dhl.png') }}'
                                class='shipment_footer rounded border border-1 border-warning bg-warning mb-sm-0 mb-1 me-sm-1'>
                            <img title='FedEx shipping service' src='{{ asset('assets/images/fedex.png') }}'
                                class='shipment_footer rounded border border-1 border-white bg-white mt-sm-0 mt-1 ms-sm-1'>
                        </div>
                        <div class='d-flex flex-column flex-sm-row align-items-center justify-content-center mt-1'>
                            <svg class='shipment_footer rounded border border-1 border-white bg-white mb-sm-0 mb-1 me-1'
                                id="layer" version="1.1" viewBox="0 0 623.54425 130.39999" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg">
                                <style id="style851" type="text/css">
                                    .st0 {
                                        fill-rule: evenodd;
                                        clip-rule: evenodd;
                                        fill: #006647;
                                    }

                                    .st1 {
                                        fill: #006647;
                                    }
                                </style>
                                <path id="path869" class="st0"
                                    d="m250.7 116.6h0.2c2.3 0 3.5 0.7 3.5 2.8 0 1.8-1 2.5-2.5 2.8l2.8 4.3h-1.7l-2.15276-3.3-0.14729-2.3c1.3 0 2.3-0.3 2.3-1.5 0-1.3-1.3-1.5-2.3-1.5zm0 13.8c4.8-0.3 8.6-3.8 8.6-9.1s-3.8-8.8-8.6-9v1.6c3.8 0.3 6.8 3.2 6.8 7.4 0 4.3-3 7.4-6.8 7.6zm-2-4h-1.5v-9.8h3.5v1.3h-2v3h2l0.14724 2.3-0.54719-1h-1.5v4.2zm2-14.1h-0.3c-4.8 0-8.8 3.5-8.8 9 0 5 3.8 9.1 8.8 9.1h0.3v-1.5h-0.3c-4.3 0-6.8-3.5-6.8-7.5 0-4.5 3-7.5 6.8-7.5h0.3z" />
                                <path id="path871" class="st1"
                                    d="m33.8 0-33.8 119.7h39.3l16.5-56.3 17.2 48.1v0.1l2.8 8.3 51.3-0.1h5.3l21-64.2 16.1 0.2-19.5 64 87 0.1 14.3-47.6-41.5 0.1 22.2-72-45.3-0.2-14.2 45.8h-16.1l6.2-21.4h-7.3l-6.5 21.4h-17.1c0.2-1.8 0.2-3.8 0.2-5.8-0.2-9-2.5-17.1-5.1-23v-0.4c-5.8-12.3-15.6-16.8-21.2-16.8zm23.3 58.1 5.5-18.4h18.6c10.1-0.5 10.8 17.6-3 18.4zm81.2 21.9h-11.5l-18.7-0.5s11-4 18.1-15.6v0.1c0.1-0.2 0.3-0.5 0.4-0.8 0.1-0.2 0.2-0.4 0.4-0.6v-0.1c1.1-2.2 2.4-4.9 3-7h15.8z" />
                                <g id="g2713">
                                    <path id="path853" class="st0"
                                        d="m315.2 45.2c0.5-6.3 1.5-18.1-6.8-18.1-4.8 0-13.3 7.1-19.5 36.7-4 18.9-4.2 36 4.3 36.2 5.5 0 10.8-7.1 14.5-19.9h10.1c-7 22.9-17 39-28.8 39-12.8-0.2-17.6-19.1-10.2-55.8 7.7-36.7 21.3-55.6 33.6-55.6 14.1 0 15.4 22.1 12.6 37.4z" />
                                    <path id="path855" class="st0"
                                        d="m353.1 10.7-6.8 19.1v-0.5l-32.2 87h10.5l7.5-21.9h17.6l-1.5 22.1h10.8l5.3-105.6zm-2.4 65.6h-12.1l6.8-18.5v0.6l8.2-23.8h0.3z" />
                                    <path id="path857" class="st0"
                                        d="m420.5 41c1.7-9.3 3.7-30.2-8.9-30.1h-24.1l-21.9 105.6h9.6l8.7-41.2h10.3c2.8 0 4.3 0.7 5 2.3 1 2 0.8 5.3 0 9.8-0.2 2.3-0.7 5-1.5 7.8-2.5 10.8-3 16.3-3.5 21.4h11l0.5-2.8c-1.8-1.8-0.8-5.5 2.5-20.9 4-19.9 2.5-23.1-0.6-26.9 5.7-3.6 10.4-13.5 12.9-25m-14.6-11.8c5.8 0 5.3 8.3 4.1 13.8-2 10.5-5.5 14.3-10.6 14.3l-11.7-0.2 6-28.2z" />
                                    <polygon id="polygon859" class="st0" transform="translate(-15,-261.6)"
                                        points="485.2 378.4 475.4 378.4 497.5 272.8 507.3 272.8" />
                                    <polygon id="polygon861" class="st0" transform="translate(-15,-261.6)"
                                        points="537.1 332.3 514 332.1 508.2 359.7 534.4 359.7 530.6 378.3 494.5 378.4 516.6 272.8 551.8 272.9 547.8 291.5 522.4 291.6 517.7 313.7 541.1 313.7" />
                                    <path id="path863" class="st0"
                                        d="m585.4 84.4c-1.2 5.8-2.2 17.1 6.3 17.1 5 0.2 10.6-2.5 13-13.6 1.7-8-1.5-10.3-5.8-13.1l-4.8-2.8c-6.8-4-13.3-7.8-8.6-30.9 2.5-11.8 9.7-32.7 25.3-32.5 14.3 0 13.9 21.1 11.4 34.2h-9.8c0.7-4.8 2.5-15.8-6.3-15.8-3.8 0-9 2.8-10.8 12.6-1.7 8.3 0.8 9.8 2.5 11.1l10.3 6c5.8 3.8 10.6 9.5 6.6 28.4-6.7 31.9-21.8 34.7-26.1 34.7-17.3 0-15.6-22.3-12.9-35.4z" />
                                    <path id="path865" class="st0"
                                        d="m468.4 41c1.7-9.3 3.7-30.2-8.9-30.1h-24.1l-21.9 105.6h9.5l8.7-41.2h10.3c2.8 0 4.3 0.7 5 2.3 1 2 0.8 5.3 0 9.8-0.3 2.3-0.8 5-1.5 7.8-2.5 10.8-3 16.3-3.5 21.4h11l0.5-2.8c-1.8-1.8-0.8-5.5 2.5-20.9 4-19.9 2.5-23.1-0.6-26.9 5.8-3.6 10.5-13.5 13-25m-14.6-11.8c5.8 0 5.3 8.3 4.1 13.8-2 10.5-5.5 14.3-10.6 14.3l-11.7-0.2 6-28.2z" />
                                    <path id="path865-4" class="st0"
                                        d="m578.7 41c1.7-9.3 3.7-30.2-8.9-30.1h-24.1l-21.9 105.6h9.5l8.7-41.2h10.3c2.8 0 4.3 0.7 5 2.3 1 2 0.8 5.3 0 9.8-0.3 2.3-0.8 5-1.5 7.8-2.5 10.8-3 16.3-3.5 21.4h11l0.5-2.8c-1.8-1.8-0.8-5.5 2.5-20.9 4-19.9 2.5-23.1-0.6-26.9 5.8-3.6 10.5-13.5 13-25m-14.6-11.8c5.8 0 5.3 8.3 4.1 13.8-2 10.5-5.5 14.3-10.6 14.3l-11.7-0.2 6-28.2z"
                                        clip-rule="evenodd" fill="#006647" fill-rule="evenodd" />
                                </g>
                            </svg>
                            <img title='DB Schenker shipping service' src='{{ asset('assets/images/db.png') }}'
                                class='shipment_footer rounded border border-1 border-white bg-white mt-sm-0 mt-1 ms-sm-1'>
                        </div>
                    </div>
                </div>
                <div class="text-center h-100 w-100 ms-lg-3 my-2 my-lg-0">
                    <h3>Follow Us</h3>
                    <div class="d-flex justify-content-center">
                        <div class='d-flex flex-column align-items-end'>
                            <a aria-label='NQK Bookstore facebook' href="#" class='mb-1'>
                                <svg fill="#ffffff" height="30px" width="30px" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="-143 145 512 512" xml:space="preserve" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M169.5,357.6l-2.9,38.3h-39.3 v133H77.7v-133H51.2v-38.3h26.5v-25.7c0-11.3,0.3-28.8,8.5-39.7c8.7-11.5,20.6-19.3,41.1-19.3c33.4,0,47.4,4.8,47.4,4.8l-6.6,39.2 c0,0-11-3.2-21.3-3.2c-10.3,0-19.5,3.7-19.5,14v29.9H169.5z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                            <a aria-label='NQK Bookstore instagram' href="#" class='my-1'>
                                <svg width="30px" height="30px" viewBox="0 0 32.00 32.00"
                                    xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"
                                    stroke-width="0.00032">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                        stroke="#CCCCCC" stroke-width="0.064"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g fill="none" fill-rule="evenodd">
                                            <path d="m0 0h32v32h-32z"></path>
                                            <path
                                                d="m17.0830929.03277248c8.1190907 0 14.7619831 6.64289236 14.7619831 14.76198302v2.3064326c0 8.1190906-6.6429288 14.761983-14.7619831 14.761983h-2.3064325c-8.11909069 0-14.76198306-6.6428924-14.76198306-14.761983v-2.3064326c0-8.11909066 6.64289237-14.76198302 14.76198306-14.76198302zm-.8630324 8.0002641-.2053832-.0002641c-1.7102378 0-3.4204757.05652851-3.4204757.05652851-2.4979736 0-4.52299562 2.02501761-4.52299562 4.52298561 0 0-.05191606 1.4685349-.05624239 3.0447858l-.00028625.2060969c0 1.7648596.05652864 3.590089.05652864 3.5900891 0 2.497968 2.02502202 4.5229856 4.52299562 4.5229856 0 0 1.5990132.0565285 3.2508899.0565285 1.7648634 0 3.6466255-.0565285 3.6466255-.0565285 2.4979736 0 4.4664317-1.9684539 4.4664317-4.4664219 0 0 .0565286-1.8046833.0565286-3.5335605l-.0010281-.4057303c-.0076601-1.5511586-.0555357-3.0148084-.0555357-3.0148084 0-2.4979681-1.9684582-4.46642191-4.4664317-4.46642191 0 0-1.6282521-.05209668-3.2716213-.05626441zm-.2053831 1.43969747c1.4024317 0 3.2005639.04637875 3.2005638.04637875 2.0483524 0 3.3130573 1.2647021 3.3130573 3.31305 0 0 .0463789 1.7674322.0463789 3.1541781 0 1.4176885-.0463789 3.2469355-.0463789 3.2469355 0 2.048348-1.2647049 3.31305-3.3130573 3.31305 0 0-1.5901757.0389711-2.9699093.0454662l-.3697206.0009126c-1.3545375 0-3.0049692-.0463788-3.0049692-.0463788-2.0483172 0-3.36958592-1.321301-3.36958592-3.3695785 0 0-.04637885-1.8359078-.04637885-3.2830941 0-1.3545344.04637885-3.061491.04637885-3.061491 0-2.0483479 1.32130402-3.31305 3.36958592-3.31305 0 0 1.7416035-.04637875 3.1440353-.04637875zm-.0000353 2.46195055c-2.2632951 0-4.0980441 1.8347448-4.0980441 4.098035s1.8347489 4.098035 4.0980441 4.098035 4.0980441-1.8347448 4.0980441-4.098035c0-2.2632901-1.8347489-4.098035-4.0980441-4.098035zm0 1.4313625c1.4727754 0 2.6666784 1.1939004 2.6666784 2.6666725s-1.193903 2.6666726-2.6666784 2.6666726c-1.4727401 0-2.6666784-1.1939005-2.6666784-2.6666726s1.1939031-2.6666725 2.6666784-2.6666725zm4.2941322-2.5685935c-.5468547 0-.9902027.4455321-.9902027.9950991 0 .5495671.443348.9950639.9902027.9950639.5468546 0 .9901674-.4454968.9901674-.9950639 0-.5496023-.4433128-.9950991-.9901674-.9950991z"
                                                fill="#ffffff" fill-rule="nonzero"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                            <a aria-label='NQK Bookstore linkedln' href="#"
                                class='d-flex align-items-center justify-content-center bg-white rounded-circle'
                                style="width:30px;height:30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20px"
                                    height="20px">
                                    <path
                                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                </svg>
                            </a>
                            <a aria-label=' NQK group github' href="https://github.com/NQK-dev-team" class='mt-1'>
                                <svg fill="#ffffff" height="30px" width="30px" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <div class='d-flex flex-column ms-1'>
                            <a aria-label='NQK Bookstore facebook' href="#"
                                class='align-middle text-start pt-1' style="height:30px">Facebook</a>
                            <a aria-label='NQK Bookstore instagram' href="#"
                                class='mt-2 align-middle text-start pt-1' style="height:30px">Instagram</a>
                            <a aria-label='NQK Bookstore X' href="#" class='mt-1 align-middle text-start pt-1'
                                style="height:30px">X (Twitter)</a>
                            <a aria-label=' NQK group github' href="https://github.com/NQK-dev-team"
                                class='align-middle text-start pt-2' style="height:30px">Github</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @yield('postloads')
    <script>
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', e => {
                const tooltips = document.querySelectorAll(`.tooltip`);
                tooltips.forEach(element => {
                    element.remove();
                });
            });

            modal.addEventListener('hidden.bs.modal', e => {
                const tooltips = document.querySelectorAll(`.tooltip`);
                tooltips.forEach(element => {
                    element.remove();
                });
            });
        });
    </script>
</body>
