<div class="d-flex align-items-center ms-md-3 mt-2 mt-md-0">
    <p class="mb-0 me-2">Publisher</p>
    <div class="dropdown">
        <form data-bs-toggle="dropdown" class="dropdown-toggle" wire:submit="$refresh" data-bs-auto-close="outside">
            <input class="form-control" id="publisherInput" type="text" placeholder="Search..." autocomplete="off"
                wire:model="search" aria-expanded="false">
        </form>
        <ul class="dropdown-menu w-100">
            @foreach ($publishers as $publisher)
                <li class="dropdown-item pointer dropdown-item">
                    {{ $publisher->publisher }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
