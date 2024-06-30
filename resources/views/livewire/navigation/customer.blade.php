<ul class="navbar-nav ms-auto" x-on:resize.window="$wire.setWidth(window.innerWidth)" x-init="$wire.setWidth(window.innerWidth);
$wire.setActiveTab(window.location.pathname)">
    <li class="nav-item mx-2">
        <a class="nav-link fs-5 d-inline-block
        {{ $activeTab === 'home' ? 'text-primary' : '' }} {{ $activeTab === 'home' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
            wire:click="setActiveTab('home')" href="{{ route('customer.index') }}">Home</a>
    </li>
    <li class="nav-item mx-2">
        <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'book' ? 'text-primary' : '' }}
                {{ $activeTab === 'book' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
            href="{{ route('customer.book.index') }}">Book</a>
    </li>
    <li class="nav-item mx-2">
        @if (auth()->check())
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'cart' ? 'text-primary' : '' }}
                {{ $activeTab === 'cart' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('customer.cart.index') }}">Cart</a>
        @else
            <a class="nav-link d-inline-block fs-5" href="{{ route('customer.authentication.index') }}">Cart</a>
        @endif
    </li>
    @if (auth()->check())
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'profile' ? 'text-primary' : '' }}
                {{ $activeTab === 'profile' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('customer.profile.index') }}">Profile</a>
        </li>
        <li class="nav-item ms-2">
            <form id="logout-form" action="{{ route('customer.authentication.logout') }}" method="POST"
                style="display: none;">
                @csrf
            </form>
            <a class="nav-link d-inline-block fs-5 text-danger text-nowrap"
                href="{{ route('customer.authentication.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
        </li>
    @else
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5" href="{{ route('customer.authentication.index') }}">Profile</a>
        </li>
        <li class="nav-item ms-2">
            <a class="nav-link d-inline-block fs-5 {{ $activeTab === 'authentication' ? 'text-primary' : '' }}
                {{ $activeTab === 'authentication' && $width >= 992 ? 'border-bottom border-3 border-primary' : '' }}"
                href="{{ route('customer.authentication.index') }}">Sign in</a>
        </li>
    @endif
</ul>
