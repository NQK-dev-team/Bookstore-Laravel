<div>
    <div class='d-flex flex-column overflow-auto'>
        <p>Current Accummulated Points:&nbsp;<span class='fw-bold'>{{ $points }}</span></p>
        <p>Loyalty Discount:&nbsp;<span class='fw-bold'>{{ $loyalty }}%</span></p>
        <p>Users Referenced:&nbsp;<span class='fw-bold'>{{ $referredNumber }}</span></p>
        <p>Referrer Discount:&nbsp;<span class='fw-bold'>{{ $refDiscount }}%</span></p>
        <div>
            <form class="d-flex align-items-center mt-2 ms-1" role="search" wire:submit="$refresh">
                <button title='Search order' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2"
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

                <input id="search_order" class="form-control me-2 search_form" type="search" wire:model="searchCode"
                    placeholder="Search by order code" aria-label="Search">
            </form>

            <label for="orderDateInput" class="form-label fw-medium mt-3">Order Date:</label>
            <input autocomplete="off" type="date" class="form-control ms-1" id="orderDateInput"
                style="max-width:500px;" wire:model.live.debounce.1000ms="searchDate">
        </div>
        <div class='w-100 flex-grow-1 my-4 overflow-x-auto hideBrowserScrollbar'>
            <table class="table table-hover border-2 table-bordered w-100 rounded">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Code</th>
                        <th scope="col">Purchase Time</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Total Discount</th>
                        <th scope="col">Book</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td class='align-middle'>{{ $index + 1 }}</td>
                            <td class='align-middle'>{{ splitOrderCode($order->code) }}</td>
                            <td class='align-middle'>
                                {{ (new DateTime($order->updated_at))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')))->format('F j, Y H:i:s') }}
                            </td>
                            <td class='align-middle'>${{ $order->total_price }}</td>
                            <td class='align-middle'>${{ $order->total_discount }}</td>
                            <td class='align-middle col-4'>
                                <div class='d-flex flex-column books pe-3'>
                                    @foreach ($order->books as $book)
                                        <p class='my-2 text-nowrap'>{{ $book['name'] }} -
                                            {{ $book['edition'] }}</p>
                                    @endforeach
                                </div>
                            </td>
                            <td class='align-middle'>
                                <div x-on:click="new bootstrap.Modal('#orderDetailModal').show();">
                                    <button class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="top"
                                        x-on:click="document.querySelectorAll('div[role=\'tooltip\']').forEach(function(tooltip) { tooltip.remove(); });
                                        $wire.getOrderDetail('{{ $order->id }}');"
                                        data-bs-title="View order detail"><i
                                            class="bi bi-info-circle text-white"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="Order detail modal"
        x-init="$el.addEventListener('hidden.bs.modal', function() {
            $wire.clearOrderDetail();
        })">
        ">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:90%;">
            @livewire('admin.manage.customer.customer-order-detail')
        </div>
    </div>
</div>
