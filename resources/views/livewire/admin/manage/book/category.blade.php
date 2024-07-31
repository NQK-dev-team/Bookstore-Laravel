<div class="d-flex align-items-center">
    <p class="mb-0 me-2">Category</p>
    <div class="dropdown">
        <form data-bs-toggle="dropdown" class="dropdown-toggle" wire:submit="$refresh" data-bs-auto-close="outside">
            <input class="form-control" id="categoryInput" type="text" placeholder="Search..." autocomplete="off"
                wire:model="search" aria-expanded="false">
        </form>
        <ul class="dropdown-menu w-100">
            @foreach ($categories as $category)
                <li class="dropdown-item pointer dropdown-item">
                    {{ $category->name }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
