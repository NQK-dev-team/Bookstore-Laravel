<div class="container-fluid h-100 d-flex flex-column">
    <h1 class='fs-2 mx-auto mt-3 mb-3'>Category List</h1>
    <div class="mb-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal">+ Add New
            Category</a>
    </div>
    <form class="d-flex align-items-center w-100" role="search"
        wire:submit="searchCategory(document.getElementById('search_category').value)">
        <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
            type="submit">
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

        <input id="search_category" class="form-control search_form" type="search"
            placeholder="Search category by name" style="max-width:900px;" aria-label="Search for category by name">
    </form>
    <div class="mt-2">
        <div class="d-flex align-items-center">
            <p class="mb-0 me-2">Show</p>
            <div>
                <select id="entry_select" class="form-select form-select-sm pointer" aria-label="Entry selection"
                    wire:model.live="limit" wire:change="resetPagination()">
                    <option value=10>10</option>
                    <option value=25>25</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                </select>
            </div>
            <p class="mb-0 ms-2">entries</p>
        </div>
    </div>
    <div class="w-100 overflow-x-auto">
        <table class="table table-hover border-2 table-bordered mt-4 w-100">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="min-width:400px;">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td class="align-middle">{{ $offset * $limit + $index + 1 }}</td>
                        <td class="col-3 align-middle">
                            {{ $category->name }}
                        </td>
                        <td class='col align-middle'>{{ $category->description }}</td>
                        <td class='col-1 align-middle' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        x-on:click="$wire.openUpdateModal('{{ $category->id }}');"
                                        data-bs-title="Detail" aria-label="Category Detail"
                                        data-bs-original-title="Category Detail">
                                        <i class="bi bi-info-circle text-white"></i>
                                    </button>
                                </div>
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <button x-on:click="$wire.selectedCategory='{{ $category->id }}';"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                        class='btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm' aria-label="Delete category"
                                        data-bs-original-title="Delete category">
                                        <i class="bi bi-trash text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="w-100 d-flex flex-sm-row flex-column justify-content-sm-between mb-4 mt-2 align-items-center">
        <div class="d-flex">
            <p>Show&nbsp;</p>
            <p>{{ $total ? $offset * $limit + 1 : 0 }}</p>
            <p>&nbsp;to&nbsp;</p>
            <p>{{ $total ? (($offset + 1) * $limit > $total ? $total : ($offset + 1) * $limit) : 0 }}</p>
            <p>&nbsp;of&nbsp;</p>
            <p>{{ $total }}</p>
            <p>&nbsp;entries</p>
        </div>
        <div class="group_button">
            <div class="btn-group d-flex" role="group">
                <button type="button" class="btn btn-outline-info" {{ $offset <= 0 ? 'disabled' : '' }}
                    wire:click="previous()">Previous</button>
                <button type="button" class="btn btn-info text-white" disabled>{{ $offset + 1 }}</button>
                <button type="button" class="btn btn-outline-info"
                    {{ ($offset + 1) * $limit >= $total ? 'disabled' : '' }} wire:click="next()">Next</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="Category information modal">
        <div class="modal-dialog modal-dialog-centered">
            @livewire('admin.manage.category.category-form')
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="Delete modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deleteCategory()">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-category-id', {
                    bubbles: true
                }));
        });

        const infoModal = document.getElementById('infoModal');
        infoModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-category-id', {
                    bubbles: true
                }));
        });

        window.addEventListener('dismiss-info-modal', function(event) {
            document.getElementById('close_modal_btn').click();
        });
    </script>
</div>
