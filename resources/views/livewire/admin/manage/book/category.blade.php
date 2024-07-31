<div class="d-flex align-items-center">
    <p class="mb-0 me-2">Category</p>
    <div class="dropdown" id="categoryDropdown">
        <form data-bs-toggle="dropdown" class="dropdown-toggle" wire:submit="searchCategories()" data-bs-auto-close="outside"
            wire:ignore.self>
            <input class="form-control" id="categoryInput" type="text" placeholder="Search..." autocomplete="off"
                wire:model="search" aria-expanded="false">
        </form>
        <ul class="dropdown-menu w-100" wire:ignore.self>
            @foreach ($categories as $category)
                <li class="dropdown-item pointer dropdown-item my-1 {{ $selectedCategory === $category->name ? 'selected' : '' }}"
                    x-on:click="$wire.setCategory(`{{ $category->name }}`)" name="category"
                    data-value="{{ $category->name }}" style="word-wrap: break-word; white-space: normal;">
                    {{ $category->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('categoryDropdown').addEventListener('hidden.bs.dropdown', function() {
                const selectedCategory = document.querySelector('li[name="category"].selected');
                if (selectedCategory) {
                    document.getElementById('categoryInput').value = selectedCategory.getAttribute(
                        'data-value');
                }
            });
        });
    </script>
</div>
