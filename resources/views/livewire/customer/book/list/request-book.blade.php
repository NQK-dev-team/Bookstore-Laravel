<div class='container-xl my-3 px-1 px-xl-3'>
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
                    data-bs-title="You can enter multiple authors with each seperated by comma">
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
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="modalLabel" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Success</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Your request was successfully sent, thank you for your contribution!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('openSuccessModal', event => {
            const successModal = new bootstrap.Modal('#successModal');
            successModal.toggle();
        });

        document.getElementById('successModal').addEventListener('hidden.bs.modal', function() {
            document.getElementsByClassName('modal-backdrop')[0].remove();

            // Remove all styles and classes added by bootstrap in the body tag
            document.body.classList.remove('modal-open');
            document.body.style = '';
        });
    </script>
</div>
