<div class="modal-content">
    <div class="modal-header">
        <div class='d-flex'>
            <h2 class="modal-title fs-5">Order:&nbsp;</h2>
            <h2 class="modal-title fs-5 fw-normal">{{ $orderDetail ? splitOrderCode($orderDetail->code) : '' }}</h2>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body
                            d-flex flex-column">
        <p>Order Time:&nbsp;
            <span class='fw-medium'>
                {{ $orderDetail? (new DateTime($orderDetail->updated_at))->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')))->format('F j, Y H:i:s'): 'N/A' }}
            </span>
        </p>
        <p>Total Discount:&nbsp;<span class='fw-medium'>${{ $orderDetail ? $orderDetail->total_discount : 0 }}</span></p>
        <p>Total Price:&nbsp;<span class='fw-medium'>${{ $orderDetail ? $orderDetail->total_price : 0 }}</span></p>
        @if ($orderDetail && count($orderDetail->eBooks))
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
                                <tr x-init="const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle=\'tooltip\']');
                                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));">
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle"><a
                                            href='{{ route('admin.manage.book.detail', ['id' => $book->id]) }}'
                                            alt="Go to book detail page"><img src="{{ $book->image }}"
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
                                                        class="bi bi-question-circle help" data-bs-toggle="tooltip"
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
                                    <td class="align-middle">
                                        @php
                                            $discount = getOrderBookDiscount($orderDetail->id, $book->id);
                                        @endphp
                                        <p class='mb-0 text-nowrap'>
                                            <span
                                                class='{{ $book->fileCopy->price && $discount ? 'text-decoration-line-through' : 'fw-medium' }}'>${{ $book->fileCopy->price }}
                                            </span>
                                            @if ($book->fileCopy->price && $discount)
                                                <span class='fw-medium ms-1'>
                                                    ${{ round(($book->fileCopy->price * (100.0 - $discount->discount)) / 100, 2) }}
                                                </span>
                                                <span class='text-danger'>
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#ff0000">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                        </g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
                                                                                    9.36039C4.2489 9.10039 4.4589 8.59038 4.4589 8.23038V6.08036C4.4589 5.20036 5.1789 4.48038
                                                                                    6.0589 4.48038H8.2089C8.5689 4.48038 9.0789 4.27041 9.3389 4.01041L10.8589 2.49039C11.4789
                                                                                    1.87039 12.4989 1.87039 13.1189 2.49039L14.6389 4.01041C14.8989 4.27041 15.4089 4.48038
                                                                                    15.7689 4.48038H17.9189C18.7989 4.48038 19.5189 5.20036 19.5189 6.08036V8.23038C19.5189
                                                                                    8.59038 19.7289 9.10039 19.9889 9.36039L21.5089 10.8804C22.1289 11.5004 22.1289 12.5204
                                                                                    21.5089 13.1404L19.9889 14.6604C19.7289 14.9204 19.5189 15.4304 19.5189
                                                                                    15.7904V17.9403C19.5189 18.8203 18.7989 19.5404 17.9189 19.5404H15.7689C15.4089 19.5404
                                                                                    14.8989 19.7504 14.6389 20.0104L13.1189 21.5304C12.4989 22.1504 11.4789 22.1504 10.8589
                                                                                    21.5304L9.3389 20.0104C9.0789 19.7504 8.5689 19.5404 8.2089 19.5404H6.0589C5.1789 19.5404
                                                                                    4.4589 18.8203 4.4589 17.9403V15.7904C4.4589 15.4204 4.2489 14.9104 3.9889 14.6604Z"
                                                                stroke="#ff0000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                            </path>
                                                            <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                            </path>
                                                            <path d="M14.4945 14.5H14.5035" stroke="#ff0000"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path d="M9.49451 9.5H9.50349" stroke="#ff0000"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>{{ $discount->discount }}%</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle"><a target="_blank" alt="Read PDF File"
                                            title="Read {{ $book->name }}" href="{{ $book->fileCopy->path }}"><i
                                                class="bi bi-file-earmark-fill text-secondary" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="Read {{ $book->name }}"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if ($orderDetail && count($orderDetail->hardCovers))
            <div class='flex-column'>
                <h5>Hardcovers</h5>
                <p>Delivery Address:&nbsp;<span class="fw-medium">{{ $orderDetail->physicalOrder->address }}</span>
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
                                            href='{{ route('admin.manage.book.detail', ['id' => $book->id]) }}'
                                            alt="Go to book detail page"><img src="{{ $book->image }}"
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
                                                        class="bi bi-question-circle help" data-bs-toggle="tooltip"
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
                                    <td class="align-middle">
                                        @php
                                            $discount = getOrderBookDiscount($orderDetail->id, $book->id);
                                        @endphp
                                        <p class='mb-0 text-nowrap'>
                                            <span
                                                class='{{ $book->physicalCopy->price && $discount ? 'text-decoration-line-through' : 'fw-medium' }}'>${{ $book->physicalCopy->price }}
                                            </span>
                                            @if ($book->physicalCopy->price && $discount)
                                                <span class='fw-medium ms-1'>
                                                    ${{ round(($book->physicalCopy->price * (100.0 - $discount->discount)) / 100, 2) }}
                                                </span>
                                                <span class='text-danger'>
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                                        stroke="#ff0000">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                        </g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
                                                                                    9.36039C4.2489 9.10039 4.4589 8.59038 4.4589 8.23038V6.08036C4.4589 5.20036 5.1789 4.48038
                                                                                    6.0589 4.48038H8.2089C8.5689 4.48038 9.0789 4.27041 9.3389 4.01041L10.8589 2.49039C11.4789
                                                                                    1.87039 12.4989 1.87039 13.1189 2.49039L14.6389 4.01041C14.8989 4.27041 15.4089 4.48038
                                                                                    15.7689 4.48038H17.9189C18.7989 4.48038 19.5189 5.20036 19.5189 6.08036V8.23038C19.5189
                                                                                    8.59038 19.7289 9.10039 19.9889 9.36039L21.5089 10.8804C22.1289 11.5004 22.1289 12.5204
                                                                                    21.5089 13.1404L19.9889 14.6604C19.7289 14.9204 19.5189 15.4304 19.5189
                                                                                    15.7904V17.9403C19.5189 18.8203 18.7989 19.5404 17.9189 19.5404H15.7689C15.4089 19.5404
                                                                                    14.8989 19.7504 14.6389 20.0104L13.1189 21.5304C12.4989 22.1504 11.4789 22.1504 10.8589
                                                                                    21.5304L9.3389 20.0104C9.0789 19.7504 8.5689 19.5404 8.2089 19.5404H6.0589C5.1789 19.5404
                                                                                    4.4589 18.8203 4.4589 17.9403V15.7904C4.4589 15.4204 4.2489 14.9104 3.9889 14.6604Z"
                                                                stroke="#ff0000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                            </path>
                                                            <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.4945 14.5H14.5035" stroke="#ff0000"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path d="M9.49451 9.5H9.50349" stroke="#ff0000"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>{{ $discount->discount }}%</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $amount = getAmount($orderDetail->id, $book->id);
                                        @endphp
                                        {{ $amount }}
                                        {{ $amount === 1 ? ' copy' : ' copies' }}
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
