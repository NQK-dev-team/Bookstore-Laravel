<div class="d-flex align-items-center ms-{{$breakpoint}}-3 mt-2 mt-{{$breakpoint}}-0">
    <p class="mb-0 me-2">Publisher</p>
    <div class="dropdown" id="publisherDropdown">
        <form data-bs-toggle="dropdown" class="dropdown-toggle" wire:submit="searchPublishers()"
            data-bs-auto-close="outside" wire:ignore.self>
            <input class="form-control" id="publisherInput" type="text" placeholder="Search..." autocomplete="off"
                wire:model="search" aria-expanded="false">
        </form>
        <ul class="dropdown-menu w-100" wire:ignore.self>
            @foreach ($publishers as $publisher)
                <li class="dropdown-item pointer dropdown-item my-1 {{ $selectedPublisher === $publisher->publisher ? 'selected' : '' }}"
                    x-on:click="$wire.setPublisher(`{{ $publisher->publisher }}`)" name="publisher"
                    data-value="{{ $publisher->publisher }}" style="word-wrap: break-word; white-space: normal;">
                    {{ $publisher->publisher }}
                </li>
            @endforeach
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('publisherDropdown').addEventListener('hidden.bs.dropdown', function() {
                const selectedPublisher = document.querySelector('li[name="publisher"].selected');
                if (selectedPublisher) {
                    document.getElementById('publisherInput').value = selectedPublisher.getAttribute(
                        'data-value');
                }
            });
        });
    </script>
</div>
