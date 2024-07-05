<div class='d-flex overflow-x-auto px-4 pb-2'>
    @foreach ($topPublishers as $publisher)
        <p class="mb-0 pointer ms-3 me-3 publisher-hover text-nowrap">
            {{ $publisher }}
        </p>
    @endforeach
</div>
