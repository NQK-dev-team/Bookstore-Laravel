<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="Select category modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5">Select category</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <div class='w-100 mt-2 mb-4'>
                    <label class="form-label" for='searchCategoryInput'>Search category:</label>
                    <form class="d-flex align-items-center w-100 mx-auto" role="search"
                        wire:submit="refreshCategoryList">
                        <button aria-label="Search for category"
                            class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.568">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M31.707 30.282l-9.717-9.776c1.811-2.169 2.902-4.96 2.902-8.007 0-6.904-5.596-12.5-12.5-12.5s-12.5 5.596-12.5 12.5 5.596 12.5 12.5 12.5c3.136 0 6.002-1.158 8.197-3.067l9.703 9.764c0.39 0.39 1.024 0.39 1.415 0s0.39-1.023 0-1.415zM12.393 23.016c-5.808 0-10.517-4.709-10.517-10.517s4.708-10.517 10.517-10.517c5.808 0 10.516 4.708 10.516 10.517s-4.709 10.517-10.517 10.517z">
                                    </path>
                                </g>
                            </svg>
                        </button>
                        <input class="form-control search_form" type='text' id='searchCategoryInput'
                            wire:model="searchCategory"></input>
                    </form>
                </div>
                <livewire:admin.manage.book.category-modal-body wire:model="bookCategories" :preSelectedCategories="$preSelectedCategories" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
