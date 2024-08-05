<div class='container-xxl my-3 px-1 px-xl-3'>
    <form class="bg-white rounded d-flex flex-column border-2 p-2" wire:submit="submit">
        <h4 class='mx-auto mt-2'>Request new book</h4>
        <small class='mx-auto text-center'>Is there a book you want to add to our store?</small>
        <small class='mx-auto text-center'>Enter the name and author below and we will get it soon...</small>
        <div class='d-flex flex-column flex-md-row p-3'>
            <div class='flex-grow-1'>
                <label for="book_name" class="form-label">Book Name:<span
                        class='fw-bold text-danger'>&nbsp;*</span></label>
                <input type="text" class="form-control" id="book_name" placeholder="Enter book name"
                    wire:model="bookName">
                <div class='text-danger'>
                    @error('bookName')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class='ms-md-3 mt-3 mt-md-0 flex-grow-1'>
                <label for="book_author" class="form-label">Author:<span
                        class='fw-bold text-danger'>&nbsp;*</span></label>
                <input type="text" class="form-control" id="book_author" placeholder="Enter author name"
                    wire:model="author" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="text-small"
                    data-bs-title="You can enter multiple authors seperated by commas">
                <div class='text-danger'>
                    @error('author')
                        {{ $message }}
                    @enderror
                </div>

            </div>
        </div>
        <div class='mb-3 mx-auto'>
            <button type='submit' class='btn btn-light border border-1 border-secondary'>Submit</button>
        </div>
    </form>
</div>
