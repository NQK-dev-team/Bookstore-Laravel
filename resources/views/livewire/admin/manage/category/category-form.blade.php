<form class="modal-content" wire:submit="{{ $selectedCategory ? ' updateCategory()' : 'createCategory()' }}">
    <div class="modal-header">
        <h2 class="modal-title fs-5">{{ $selectedCategory ? 'Category Details' : 'Add New Category' }}</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close_modal_btn"></button>
    </div>
    <div class="modal-body d-flex flex-column">
        <label class='form-label'>Category Name:<span class='fw-bold text-danger'>&nbsp;*</span></label>
        <input type="text" class='form-control {{ $errors->has('categoryName') ? 'is-invalid' : '' }}' required
            maxlength="255" wire:model="categoryName">
        @if ($errors->has('categoryName'))
            <div class="invalid-feedback">
                {{ $errors->first('categoryName') }}
            </div>
        @endif
        <label class='form-label mt-3'>Description:<span class='fw-bold text-danger'>&nbsp;*</span></label>
        <textarea rows="5" class='form-control {{ $errors->has('categoryDescription') ? 'is-invalid' : '' }}' required
            maxlength="500" wire:model="categoryDescription"></textarea>
        @if ($errors->has('categoryDescription'))
            <div class="invalid-feedback">
                {{ $errors->first('categoryDescription') }}
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">{{ $selectedCategory ? 'Update' : 'Add' }}</button>
    </div>
</form>
