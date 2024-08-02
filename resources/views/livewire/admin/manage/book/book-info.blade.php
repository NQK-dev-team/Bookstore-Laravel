<div>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="Book Information modal" x-init="if ({{ $openInfoModal ? 'true' : 'false' }}) {
        new bootstrap.Modal($el).toggle();
    }">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">{{ $bookID ? $bookName : 'Add a new book' }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">{{ $bookID ? 'Update' : 'Add' }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const infoModal = document.getElementById('infoModal');
        infoModal.addEventListener('hidden.bs.modal', function(event) {
            // document.getElementById('book-list-container').dispatchEvent(new CustomEvent(
            //     'alpine-reset-book-id', {
            //         bubbles: true
            //     }));
            window.dispatchEvent(new CustomEvent(
                'reset-book-id', {
                    bubbles: true
                }));
        });
    </script>
</div>
