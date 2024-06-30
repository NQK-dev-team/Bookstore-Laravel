<ul class="navbar-nav ms-auto" x-on:resize.window="$wire.setWidth(window.innerWidth)" x-init="$wire.setWidth(window.innerWidth);
$wire.setActiveTab(window.location.pathname)">
    <li class="nav-item mx-2">
        @if (auth()->check())
            <a class="nav-link fs-5 d-inline-block
        {{ $activeTab === 'home' ? 'text-primary' : '' }} {{ $activeTab === 'home' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                wire:click="setActiveTab('home')" href="{{ route('admin.index') }}">Home</a>
        @else
            <a class="nav-link fs-5 d-inline-block" href="{{ route('admin.authentication.index') }}">Home</a>
        @endif
    </li>
    <li class="nav-item dropdown mx-2">
        <p class="nav-link m-0 fs-5 d-inline-block {{ in_array($activeTab, ['book', 'category', 'customer', 'coupon', 'request']) ? 'text-primary' : '' }}
        {{ in_array($activeTab, ['book', 'category', 'customer', 'coupon', 'request']) && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
            role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage
            <svg width="16px" height="16px"
                fill="{{ in_array($activeTab, ['book', 'category', 'customer', 'coupon', 'request']) ? '#007bff' : '#000000' }}"
                stroke="{{ in_array($activeTab, ['book', 'category', 'customer', 'coupon', 'request']) ? '#007bff' : '#000000' }}"
                version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke-width="5">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                </g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <path
                            d="M78.466,35.559L50.15,63.633L22.078,35.317c-0.777-0.785-2.044-0.789-2.828-0.012s-0.789,2.044-0.012,2.827L48.432,67.58 c0.365,0.368,0.835,0.563,1.312,0.589c0.139,0.008,0.278-0.001,0.415-0.021c0.054,0.008,0.106,0.021,0.16,0.022 c0.544,0.029,1.099-0.162,1.515-0.576l29.447-29.196c0.785-0.777,0.79-2.043,0.012-2.828S79.249,34.781,78.466,35.559z">
                        </path>
                    </g>
                </g>
            </svg>
        </p>
        <ul class="dropdown-menu">
            @if (auth()->check())
                <li>
                    <a class="dropdown-item {{ $activeTab === 'book' ? 'text-primary' : '' }}"
                        href="{{ route('admin.manage.book.index') }}">Book</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $activeTab === 'category' ? 'text-primary' : '' }}"
                        href="{{ route('admin.manage.category.index') }}">Category</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $activeTab === 'customer' ? 'text-primary' : '' }}"
                        href="{{ route('admin.manage.customer.index') }}">Customer</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $activeTab === 'coupon' ? 'text-primary' : '' }}"
                        href="{{ route('admin.manage.coupon.index') }}">Coupon</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $activeTab === 'request' ? 'text-primary' : '' }}"
                        href="{{ route('admin.manage.request.index') }}">Request</a>
                </li>
            @else
                <li>
                    <a class="dropdown-item" href="{{ route('admin.authentication.index') }}">Book</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.authentication.index') }}">Category</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.authentication.index') }}">Customer</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.authentication.index') }}">Coupon</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.authentication.index') }}">Request</a>
                </li>
            @endif
        </ul>
    </li>
    <li class="nav-item mx-2">
        @if (auth()->check())
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'statistic' ? 'text-primary' : '' }}
                {{ $activeTab === 'statistic' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('admin.statistic.index') }}">Statistic</a>
        @else
            <a class="nav-link d-inline-block fs-5" href="{{ route('admin.authentication.index') }}">Statistic</a>
        @endif
    </li>
    @if (auth()->check())
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'profile' ? 'text-primary' : '' }}
                {{ $activeTab === 'profile' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('admin.profile.index') }}">Profile</a>
        </li>
        <li class="nav-item ms-2">
            <form id="logout-form" action="{{ route('admin.authentication.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link d-inline-block fs-5 text-danger text-nowrap" href="{{ route('admin.authentication.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
        </li>
    @else
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5" href="{{ route('admin.authentication.index') }}">Profile</a>
        </li>
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'authentication' ? 'text-primary' : '' }}
                {{ $activeTab === 'authentication' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('admin.authentication.index') }}">Sign in</a>
        </li>
    @endif
</ul>
