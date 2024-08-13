<div class="container-fluid h-100 d-flex flex-column">
    <h1 class='fs-2 mx-auto mt-3 mb-3'>Customer List</h1>
    <form class="d-flex align-items-center w-100" role="search"
        wire:submit="searchCustomer(document.getElementById('search_customer').value)">
        <button title='Submit search form' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
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

        <input id="search_customer" class="form-control search_form" type="search"
            placeholder="Search customer by name, email or phone number" style="max-width:900px;"
            aria-label="Search customer by name, email or phone number">
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
                    <th scope="col">Email</th>
                    <th scope="col" class='text-nowrap'>Phone Number</th>
                    <th scope="col" class='text-nowrap'>Date of Birth</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                    <th scope="col" class='text-nowrap'>Accumulated Points</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                    <tr>
                        <td class="align-middle">{{ $offset * $limit + $index + 1 }}</td>
                        <td class="align-middle text-nowrap">{{ $customer->name }}</td>
                        <td class='align-middle text-nowrap'>{{ $customer->email }}</td>
                        <td class='align-middle text-nowrap'>{{ $customer->phone }}</td>
                        <td class='align-middle text-nowrap'>{{ date('F j, Y', strtotime($customer->dob)) }}</td>
                        <td class='align-middle text-nowrap'>{{ $customer->address ? $customer->address : 'N/A' }}</td>
                        <td class='align-middle text-nowrap'>
                            {{ $customer->gender === 'M' ? 'Male' : ($customer->gender === 'F' ? 'Female' : 'Other') }}
                        </td>
                        <td class='align-middle text-nowrap'>{{ $customer->points }}</td>
                        <td class='col-1 align-middle' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        x-on:click="$dispatch('clear-error-bag'); $wire.openInfoModal('{{ $customer->id }}');"
                                        data-bs-title="Detail" aria-label="Customer Detail"
                                        data-bs-original-title="Customer Detail">
                                        <i class="bi bi-info-circle text-white"></i>
                                    </button>
                                </div>
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <button x-on:click="$wire.selectedCustomer='{{ $customer->id }}';"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                        class='btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm' aria-label="Delete customer"
                                        data-bs-original-title="Delete customer">
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

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="Customer information modal">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
            @livewire('admin.manage.customer.customer-info-form')
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
                    <p>Are you sure you want to delete this customer?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deleteCustomer()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        const infoModal = document.getElementById('infoModal');
        infoModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-customer-id', {
                    bubbles: true
                }));
        });
    </script> --}}
</div>
