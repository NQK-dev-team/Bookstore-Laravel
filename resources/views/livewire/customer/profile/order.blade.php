<div class='d-flex flex-column overflow-auto'>
    <p>Current Accummulated Points:&nbsp;<span class='fw-bold'>{{ $points }}</span></p>
    <p>Loyalty Discount:&nbsp;<span class='fw-bold'>{{ $loyalty ? $loyalty : 0 }}%</span></p>
    <p>Users Referenced:&nbsp;<span class='fw-bold'>{{ $referredNumber }}</span></p>
    <p>Referrer Discount:&nbsp;<span class='fw-bold'>{{ $refDiscount ? $refDiscount : 0 }}%</span></p>
    <div>
        <form class="d-flex align-items-center mt-2 ms-1" role="search" wire:submit="$refresh">
            <button title='Search order' class="p-0 border-0 position-absolute bg-transparent mb-1 ms-2" type="submit">
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
        <input autocomplete="off" type="date" class="form-control ms-1" id="orderDateInput" style="max-width:500px;"
            wire:model.live.debounce.1000ms="searchDate">
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
                        <td class='align-middle'>{{ date('F j, Y H:i:s', strtotime($order->updated_at)) }}</td>
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
                            <button class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="top"
                                x-on:click="document.querySelectorAll('div[role=\'tooltip\']').forEach(function(tooltip) { tooltip.remove(); }); $wire.order_id='{{ $order->id }}'; $wire.getOrderDetail();"
                                data-bs-title="View order detail"><i class="bi bi-info-circle text-white"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($order_id)
        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="Order modal" x-init="const modal = new bootstrap.Modal('#orderModal');
        modal.toggle();
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle=\'tooltip\']');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class='d-flex'>
                            <h2 class="modal-title fs-5">Order:&nbsp;</h2>
                            <h2 class="modal-title fs-5 fw-normal">{{ splitOrderCode($orderDetail->code) }}</h2>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            x-on:click="$wire.order_id=null; $wire.$refresh();"></button>
                    </div>
                    <div class="modal-body
                            d-flex flex-column">
                        <p>Order Time:&nbsp;<span
                                class='fw-medium'>{{ date('F j, Y H:i:s', strtotime($orderDetail->updated_at)) }}</span>
                        </p>
                        <p>Total Discount:&nbsp;<span class='fw-medium'>${{ $orderDetail->total_discount }}</span></p>
                        <p>Total Price:&nbsp;<span class='fw-medium'>${{ $orderDetail->total_price }}</span></p>
                        @if ($orderDetail->fileOrder)
                            <div class='flex-column mb-3'>
                                <h5>E-books</h5>
                                <div class="w-100 overflow-x-auto">
                                    <table class="table table-hover border-2 table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Edition</th>
                                                <th scope="col">ISBN-13</th>
                                                <th scope="col">Author</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Publisher</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Rating</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderDetail->eBooks as $index => $book)
                                                <tr>
                                                    <td class="align-middle">{{ $index + 1 }}</td>
                                                    <td class="align-middle"><a
                                                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'
                                                            alt="Go to book detail page"><img
                                                                src="{{ $book->image }}"
                                                                alt="{{ $book->name }} {{ $book->edition }} image"
                                                                class="book_image"></a></td>
                                                    <td class="col-2 align-middle">{{ $book->name }}</td>
                                                    <td class="align-middle text-nowrap">{{ $book->edition }}</td>
                                                    <td class="align-middle text-nowrap">{{ $book->isbn }}</td>
                                                    <td class="col-1 align-middle">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $temp = explode(', ', $book->authors);
                                                            @endphp
                                                            @foreach ($temp as $author)
                                                                <p class="my-2 text-nowrap">{{ $author }}</p>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $temp = explode(', ', $book->categories);
                                                            @endphp
                                                            @foreach ($temp as $category)
                                                                <p class="my-2 text-nowrap">{{ $category }} <i
                                                                        class="bi bi-question-circle help"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        data-bs-title="{{ getCategoryDescription($category) }}"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="d-flex flex-column">
                                                            <p class="text-nowrap">{{ $book->publisher }}</p>
                                                            <p class="text-nowrap">{{ $book->publication_date }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="truncate">{{ $book->description }}</div>
                                                    </td>
                                                    <td class="align-middle col-1"><span class="text-nowrap"><span
                                                                class="text-warning">{!! displayRatingStars($book->average_rating) !!}</span>
                                                            ({{ $book->average_rating }})
                                                        </span>
                                                    </td>
                                                    <td class="align-middle"></td>
                                                    <td class="align-middle"><a target="_blank" alt="Read PDF File"
                                                            title="Read {{ $book->name }}"
                                                            href="{{ $book->fileCopy->path }}"><i
                                                                class="bi bi-file-earmark-fill text-secondary"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Read {{ $book->name }}"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if ($orderDetail->physicalOrder)
                            <div class='flex-column'>
                                <h5>Hardcovers</h5>
                                <p>Delivery Address:&nbsp;<span
                                        class="fw-medium">{{ $orderDetail->physicalOrder->address }}</span>
                                </p>
                                <div class="w-100 overflow-x-auto">
                                    <table class="table table-hover border-2 table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Edition</th>
                                                <th scope="col">ISBN-13</th>
                                                <th scope="col">Author</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Publisher</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Rating</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Ammount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderDetail->hardCovers as $index => $book)
                                                <tr>
                                                    <td class="align-middle">{{ $index + 1 }}</td>
                                                    <td class="align-middle"><a
                                                            href='{{ route('customer.book.detail', ['id' => $book->id]) }}'
                                                            alt="Go to book detail page"><img
                                                                src="{{ $book->image }}"
                                                                alt="{{ $book->name }} {{ $book->edition }} image"
                                                                class="book_image"></a></td>
                                                    <td class="col-2 align-middle">{{ $book->name }}</td>
                                                    <td class="align-middle text-nowrap">{{ $book->edition }}</td>
                                                    <td class="align-middle text-nowrap">{{ $book->isbn }}</td>
                                                    <td class="col-1 align-middle">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $temp = explode(', ', $book->authors);
                                                            @endphp
                                                            @foreach ($temp as $author)
                                                                <p class="my-2 text-nowrap">{{ $author }}</p>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $temp = explode(', ', $book->categories);
                                                            @endphp
                                                            @foreach ($temp as $category)
                                                                <p class="my-2 text-nowrap">{{ $category }} <i
                                                                        class="bi bi-question-circle help"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        data-bs-title="{{ getCategoryDescription($category) }}"></i>
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="d-flex flex-column">
                                                            <p class="text-nowrap">{{ $book->publisher }}</p>
                                                            <p class="text-nowrap">{{ $book->publication_date }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle col-1">
                                                        <div class="truncate">{{ $book->description }}</div>
                                                    </td>
                                                    <td class="align-middle col-1"><span class="text-nowrap"><span
                                                                class="text-warning">{!! displayRatingStars($book->average_rating) !!}</span>
                                                            ({{ $book->average_rating }})
                                                        </span>
                                                    </td>
                                                    <td class="align-middle"></td>
                                                    <td class="align-middle">
                                                        {{ $orderDetail->physicalOrder->physicalCopies[$index]->pivot->amount }}
                                                        {{ $orderDetail->physicalOrder->physicalCopies[$index]->pivot->amount === 1 ? ' copy' : ' copies' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            x-on:click="$wire.order_id=null; $wire.$refresh();">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
