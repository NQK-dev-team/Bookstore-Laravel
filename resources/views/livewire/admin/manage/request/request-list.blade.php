<div class="container-fluid h-100 d-flex flex-column">
    <h1 class='fs-2 mx-auto mt-3 mb-3'>Request List</h1>
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
                    <th scope="col">Authors</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $index => $request)
                    <tr>
                        <td class="align-middle col-1">{{ $offset * $limit + $index + 1 }}</td>
                        <td class="align-middle text-nowrap">
                            {{ $request->name }}
                        </td>
                        <td class='col align-middle text-nowrap'>{{ $request->author }}</td>
                        <td class='col align-middle text-nowrap'>
                            {{ date('F j, Y H:i:s', strtotime($request->created_at)) }}</td>
                        <td class='col-1 align-middle'>
                            <div class="d-flex flex-lg-row flex-column">
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <button x-on:click="$wire.selectedRequest='{{ $request->id }}';"
                                        x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Delete request" class='btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm'
                                        aria-label="Delete request" data-bs-original-title="Delete request">
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="Delete modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to delete this request?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deleteRequest()">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-request-id', {
                    bubbles: true
                }));
        });
    </script>
</div>
