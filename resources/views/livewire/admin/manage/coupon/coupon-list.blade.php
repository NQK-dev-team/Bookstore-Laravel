<div>
    <div class="container-fluid h-100 d-flex flex-column">
        <h1 class='fs-2 mx-auto mt-3'>Discount Coupon List</h1>
        <div class='mt-2'>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal">+ Add New
                Coupon</button>
            <form class="d-flex align-items-center w-100 mt-2" role="search" wire:submit="resetPagination()">
                <button title='search coupon' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
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

                <input id="search_coupon" class="form-control me-2 search_form" type="search" style="max-width:900px;"
                    wire:model="search" placeholder="Search coupon by name" aria-label="Search for coupon by name">
            </form>
        </div>
        <div class="mt-2">
            @if ((int) $couponType === 1)
                <div class="d-flex flex-md-row flex-column pe-2">
                    <div class="d-flex align-items-center me-md-3">
                        <p class="text-nowrap mb-0">Start Date</p>
                        <input type="date" class="form-control ms-2" id="inputStartDate" wire:model.live="startDate"
                            style="max-width: 200px;" wire:change="resetPagination()">
                    </div>
                    <div class="mt-2 mt-md-0 d-flex align-items-center">
                        <p class="text-nowrap mb-0">End Date</p>
                        <input type="date" class="form-control ms-2" id="inputEndDate" wire:model.live="endDate"
                            style="max-width: 200px;" wire:change="resetPagination()">
                    </div>
                </div>
            @endif
            <div class="d-flex align-items-center @if ((int) $couponType === 1) mt-2 @endif">
                <p class="mb-0 me-2">Coupon Type</p>
                <div>
                    <select class="form-select pointer" aria-label="Select coupon type" id='couponSelect'
                        wire:model.live="couponType" wire:change="resetPagination()">
                        <option value="1">Event</option>
                        <option value="2">Loyalty</option>
                        <option value="3">Referrer</option>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center mt-2">
                <p class="mb-0 me-2">Show</p>
                <div>
                    <select id="entry_select" class="form-select form-select-sm pointer" aria-label="Entry selection"
                        wire:model.live="limit" wire:change="resetPagination()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <p class="mb-0 ms-2">entries</p>
            </div>
            <div class="mt-2">
                <div class="form-check form-switch">
                    <label class="form-check-label {{ $status ? 'text-success' : 'text-danger' }}"
                        for="status_switch">{{ $status ? 'Active coupons' : 'Inactive coupons' }}</label>
                    <input title='Coupon status switch' class="form-check-input pointer" type="checkbox" role="switch"
                        id="status_switch" wire:model.live="status" wire:change="resetPagination()">
                </div>
            </div>
        </div>
        <div class="w-100 overflow-x-auto">
            <table class="table table-hover border border-2 table-bordered mt-4 w-100">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" class='text-nowrap'>Discount Percentage</th>
                        @if ((int) $couponType === 1)
                            <th scope="col" class='text-nowrap'>Start Time</th>
                            <th scope="col" class='text-nowrap'>End Time</th>
                            <th scope="col" class='text-nowrap'>Books Applied</th>
                            @if ($status)
                                <th scope="col">Status</th>
                            @endif
                        @elseif ((int) $couponType === 2)
                            <th scope="col" class='text-nowrap'>Accumulated Points</th>
                        @elseif ((int) $couponType === 3)
                            <th scope="col" class='text-nowrap'>Number of People</th>
                        @endif
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $index => $coupon)
                        <tr>
                            <td class="align-middle">{{ $offset * $limit + $index + 1 }}</td>
                            <td class="align-middle text-nowrap col-3">{{ $coupon->name }}</td>
                            <td class="align-middle col-1">{{ $coupon->discount }}%</td>
                            @if ((int) $couponType === 1)
                                <td class="align-middle text-nowrap">
                                    {{ (new DateTime($coupon->eventDiscount->start_time))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')))->format('F j, Y H:i:s') }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    {{ (new DateTime($coupon->eventDiscount->end_time))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')))->format('F j, Y H:i:s') }}
                                </td>
                                <td class="align-middle text-nowrap">
                                    @if ($coupon->eventDiscount->apply_for_all_books)
                                        <div>All</div>
                                    @else
                                        <div class='overflow-auto' style="max-height:300px;">
                                            @php
                                                $books = $coupon->eventDiscount->booksApplied;
                                                $books = $books->sortBy([['name', 'asc'], ['edition', 'asc']]);
                                            @endphp
                                            @foreach ($books as $book)
                                                <a class="text-decoration-none d-block my-2"
                                                    href="{{ route('admin.manage.book.detail', ['id' => $book->id]) }}">{{ $book->name }}
                                                    - {{ convertToOrdinal($book->edition) }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                @if ($status)
                                    <td class="align-middle text-nowrap">
                                        @if ((new DateTime($coupon->eventDiscount->start_time))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))) > (new DateTime('now'))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))))
                                            <span class="text-secondary">Upcoming</span>
                                        @else
                                            <span class="text-success">Ongoing</span>
                                        @endif
                                    </td>
                                @endif
                            @elseif ((int) $couponType === 2)
                                <td class="align-middle col-7">{{ $coupon->customerDiscount->point }}</td>
                            @elseif ((int) $couponType === 3)
                                <td class="align-middle col-7">{{ $coupon->referrerDiscount->number_of_people }}</td>
                            @endif
                            <td class='align-middle col-1' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))">
                                <div class="d-flex flex-lg-row flex-column">
                                    <div class='text-center' data-bs-toggle="modal" data-bs-target="#infoModal">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" wire:click="setCouponID('{{ $coupon->id }}');"
                                            data-bs-title="Detail" aria-label="Coupon Detail"
                                            data-bs-original-title="Coupon Detail">
                                            <i class="bi bi-info-circle text-white"></i>
                                        </button>
                                    </div>
                                    @if ($status)
                                        <div class='text-center' data-bs-toggle="modal"
                                            data-bs-target="#deactivateModal">
                                            <button x-on:click="$wire.couponID='{{ $coupon->id }}';"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Deactivate"
                                                class="btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm"
                                                aria-label="Deactivate coupon"
                                                data-bs-original-title="Deactivate coupon">
                                                <i class="bi bi-power text-white"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class='text-center' data-bs-toggle="modal"
                                            data-bs-target="#activateModal">
                                            <button x-on:click="$wire.couponID='{{ $coupon->id }}';"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Activate"
                                                class="btn btn-success ms-lg-2 mt-2 mt-lg-0 btn-sm"
                                                aria-label="Activate coupon" data-bs-original-title="Activate coupon">
                                                <i class="bi bi-power text-white"></i>
                                            </button>
                                        </div>
                                    @endif
                                    <div class='text-center' data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <button x-on:click="$wire.couponID='{{ $coupon->id }}';"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                            class='btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm'
                                            aria-label="Delete coupon" data-bs-original-title="Delete coupon">
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
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="Coupon information modal">
        <div class="modal-dialog modal-dialog-centered">
            @livewire('admin.manage.coupon.coupon-info', ['couponType' => $couponType, 'status' => $status])
        </div>
    </div>

    <div class="modal fade" id="bookListModal" tabindex="-1" aria-labelledby="Books applied list modal" x-init="
        $el.addEventListener('shown.bs.modal', function(event) {
            while(document.querySelectorAll('.modal-backdrop').length > 2){
                document.querySelectorAll('.modal-backdrop')[0].remove();
            }
        });
    ">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Books Applied</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @livewire('admin.manage.coupon.book-list')
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
                    <p>Are you sure you want to delete this discount coupon?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deleteCoupon()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="Deactivate modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to deactivate this discount coupon?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deactivateCoupon()">Deactivate</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="Activate modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to reactivate this discount coupon?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                        wire:click="reactivateCoupon()">Activate</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="activateErrorModal" tabindex="-1" aria-labelledby="Activate modal"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Some of the values in the discount coupon has already been used by another coupon.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-coupon-id', {
                    bubbles: true
                }));
        });

        const deactivateModal = document.getElementById('deactivateModal');
        deactivateModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-coupon-id', {
                    bubbles: true
                }));
        });

        const activateModal = document.getElementById('activateModal');
        activateModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-coupon-id', {
                    bubbles: true
                }));
        });

        const infoModal = document.getElementById('infoModal');
        infoModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-coupon-id', {
                    bubbles: true
                }));
        });
    </script>
    <script>
        window.addEventListener('dismiss-coupon-info-modal', function(event) {
            document.getElementById('close_modal_btn').click();
        });

        window.addEventListener('activate-error-modal', function(event) {
            new bootstrap.Modal('#activateErrorModal').toggle();
        });
    </script>
</div>
