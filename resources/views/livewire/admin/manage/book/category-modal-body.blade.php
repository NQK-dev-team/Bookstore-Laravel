<div>
    <div class="category-modal px-1">
        @foreach ($categories as $index => $category)
            @if ($index % 2 == 0)
                <div class='d-flex flex-sm-row flex-column w-100'>
            @endif
            <div class="form-check mx-auto check_box">
                <input class="form-check-input pointer" type="checkbox" value="{{ $category->id }}" name="category_checkboxes"
                    x-on:change="if(event.target.checked) {
                        $dispatch('add-category', { id: `{{ $category->id }}`, name: `{{ $category->name }}` });
                    } else {
                        $dispatch('remove-category', { id: `{{ $category->id }}`, name: `{{ $category->name }}` });
                    }"
                    @if (in_array($category->id, $preSelectedCategories)) checked @endif style="width:1.1rem; height:1.1rem;"
                    id="{{ $category->id }}">
                <label class="form-check-label" for="{{ $category->id }}" x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
                    tooltipTriggerEl))">
                    {{ $category->name }}
                    <i class="bi bi-question-circle help ms-2 my-1" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="{{ $category->description ? $category->description : 'N/A' }}"></i>
                </label>
            </div>
            @if ($index % 2 == 0 && $index == count($categories) - 1)
                <div class="mx-auto check_box" aria-label="Dummy Element"></div>
    </div>
    @endif
    @if ($index % 2 == 1)
</div>
@endif
@endforeach
</div>
</div>
