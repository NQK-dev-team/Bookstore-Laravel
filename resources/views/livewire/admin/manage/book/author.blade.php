<div class="d-flex align-items-center ms-md-3 mt-2 mt-md-0">
    <p class="mb-0 me-2">Author</p>
    <div class="dropdown" id="authorDropdown">
        <form data-bs-toggle="dropdown" class="dropdown-toggle" wire:submit="searchAuthors()" data-bs-auto-close="outside"
            wire:ignore.self>
            <input class="form-control" id="authorInput" type="text" placeholder="Search..." autocomplete="off"
                wire:model.live="search" aria-expanded="false">
        </form>
        <ul class="dropdown-menu w-100" wire:ignore.self>
            @foreach ($authors as $author)
                <li class="dropdown-item pointer dropdown-item my-1 {{ $selectedAuthor === $author->name ? 'selected' : '' }}"
                    x-on:click="$wire.setAuthor(`{{ $author->name }}`)" name="author" data-value="{{ $author->name }}"
                    style="word-wrap: break-word; white-space: normal;">
                    {{ $author->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('authorDropdown').addEventListener('hidden.bs.dropdown', function() {
                const selectedAuthor = document.querySelector('li[name="author"].selected');
                if (selectedAuthor) {
                    document.getElementById('authorInput').value = selectedAuthor.getAttribute(
                        'data-value');
                }
            });
        });
    </script>
</div>
