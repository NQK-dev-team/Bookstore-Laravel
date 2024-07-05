<div class='d-flex overflow-x-auto px-4 pb-2'>
    @foreach ($topCategories as $category)
        <p class="mb-0 pointer ms-3 me-3 publisher-hover text-nowrap">
            {{ $category }}
        </p>
    @endforeach
</div>
