<form wire:submit="searchCategory">
    <h5>Category</h5>
    <div class="d-flex align-items-center">
        <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                    </path>
                </g>
            </svg>
        </button>
        <input id="search_category" class="form-control search_form" type="search" placeholder="Search category"
            aria-label="Search category" wire:model="category">
    </div>
    <div class='ps-2 mt-2 item-list'>
        @foreach ($categories as $category)
            <p class="pointer {{ $selectedCategory === $category ? 'item-chosen' : '' }}"
                x-on:click="$wire.selectCategory(`{{ $category }}`)">{{ $category }}</p>
        @endforeach
    </div>
</form>
