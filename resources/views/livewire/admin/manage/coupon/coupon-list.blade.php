<div>
    <div class="container-fluid h-100 d-flex flex-column">
        <h1 class='fs-2 mx-auto mt-3'>Discount Coupon List</h1>
        <div class='mt-2'>
            <button class="btn btn-primary btn-sm">+ Add New Coupon</button>
            <form class="d-flex align-items-center w-100 mt-2" role="search" wire:submit="$refresh">
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
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2">Coupon Type</p>
                <div>
                    <select class="form-select pointer" aria-label="Select coupon type" id='couponSelect'
                        wire:model.live="couponType" wire:change="resetPagination()">
                        <option value={{ 1 }}>Event</option>
                        <option value={{ 2 }}>Loyalty</option>
                        <option value={{ 3 }}>Referrer</option>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center mt-2">
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
                <thead id="table_head">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" class='text-nowrap'>Discount Percentage</th>
                        @if ($couponType === 1)
                            <th scope="col" class='text-nowrap'>Start Time</th>
                            <th scope="col" class='text-nowrap'>End Time</th>
                            <th scope="col" class='text-nowrap'>Books Applied</th>
                            @if ($status)
                                <th scope="col">Status</th>
                            @endif
                        @elseif ($couponType === 2)
                            <th scope="col" class='text-nowrap'>Accumulated Points</th>
                        @elseif ($couponType === 3)
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
                            @if ($couponType === 1)
                                <td class="align-middle text-nowrap"></td>
                                <td class="align-middle text-nowrap"></td>
                                <td class="align-middle text-nowrap"></td>
                                @if ($status)
                                    <td class="align-middle text-nowrap"></td>
                                @endif
                            @elseif ($couponType === 2)
                                <td class="align-middle"></td>
                            @elseif ($couponType === 3)
                                <td class="align-middle"></td>
                            @endif
                            <td class='align-middle col-1' x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`)
                            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))">
                                <div class="d-flex flex-lg-row flex-column">
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
</div>
