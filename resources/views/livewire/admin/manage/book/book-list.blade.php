<div class="container-fluid h-100 d-flex flex-column">
    <h1 class='fs-2 mx-auto mt-3 mb-3'>Book List</h1>
    <div class="mb-2">
        <a class="btn btn-primary btn-sm" href="{{ route('admin.manage.book.add') }}">+ Add New
            Book</a>
    </div>
    <form class="d-flex align-items-center w-100" role="search"
        wire:submit="searchBook(document.getElementById('search_book').value)">
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

        <input id="search_book" class="form-control search_form" type="search" placeholder="Search book by name"
            style="max-width:900px;" aria-label="Search for book by name">
    </form>
    <div class="mt-2 d-flex flex-md-row flex-column">
        @livewire('admin.manage.book.category')
        @livewire('admin.manage.book.author')
        @livewire('admin.manage.book.publisher')
    </div>
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
        <div class="mt-2">
            <div class="form-check form-switch">
                <label class="form-check-label" for="statusSwitch">Choose
                    active books</label>
                <input title='Book status' class="form-check-input pointer" type="checkbox" role="switch"
                    id="statusSwitch" wire:model.live="status" wire:change="resetPagination()">
            </div>
        </div>
    </div>
    <div class="w-100 overflow-x-auto">
        <table class="table table-hover border-2 table-bordered mt-4 w-100">
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
                @foreach ($books as $index => $book)
                    <tr>
                        <td class="align-middle">{{ $offset * $limit + $index + 1 }}</td>
                        <td class="align-middle"><img src="{{ $book->image }}"
                                alt="{{ $book->name }} {{ $book->edition }} image" class="book_image"></td>
                        <td class="col-2 align-middle">
                            <div style="width:200px;">{{ $book->name }}</div>
                        </td>
                        <td class="align-middle text-nowrap">{{ $book->edition }}</td>
                        <td class="align-middle text-nowrap">{{ $book->isbn }}</td>
                        <td class="align-middle col-1 text-nowrap">
                            <div class="d-flex flex-column">
                                @php
                                    $authors = explode(', ', $book->authors);
                                @endphp
                                @foreach ($authors as $author)
                                    <p class="my-1">{{ $author }}</p>
                                @endforeach
                            </div>
                        </td>
                        <td class="align-middle col-1 text-nowrap">
                            <div class="d-flex flex-column">
                                @php
                                    $categories = explode(', ', $book->categories);
                                @endphp
                                @foreach ($categories as $category)
                                    <p class="my-1">{{ $category }} <i class="bi bi-question-circle help"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{ getCategoryDescription($category) }}"></i></p>
                                @endforeach
                            </div>
                        </td>
                        <td class="align-middle col-1 text-nowrap">
                            <div class="d-flex flex-column">
                                <p>{{ $book->publisher }}</p>
                                <p class="text-nowrap">{{ $book->publication_date }}</p>
                            </div>
                        </td>
                        <td class="align-middle col-1">
                            <div class="truncate" style="width:300px;">
                                {{ $book->description ? $book->description : 'N/A' }}</div>
                        </td>
                        <td class="align-middle col-1 text-nowrap">
                            <span class='text-warning'>{!! displayRatingStars($book->average_rating) !!}</span></span
                                class='ms-2'>({{ $book->average_rating }})</span>
                        </td>
                        @php
                            $discount = getBookBestDiscount($book);
                        @endphp
                        <td class="align-middle col-1 text-nowrap">
                            <div class="d-flex flex-column">
                                <p>Hardcover:
                                    @if ($book->physicalCopy && $book->physicalCopy->price !== null)
                                        @if ($discount)
                                            <span
                                                class="text-decoration-line-through ms-1">${{ $book->physicalCopy->price }}</span>
                                            <span
                                                class='ms-1'>${{ round(($book->physicalCopy->price * (100.0 - $discount->discount)) / 100, 2) }}</span>
                                            <svg class='ms-1' width="24px" height="24px" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
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
                                                        stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                    <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.4945 14.5H14.5035" stroke="#ff0000" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M9.49451 9.5H9.50349" stroke="#ff0000" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                            </svg><span class='text-danger'>{{ $discount->discount }}%</span>
                                        @else
                                            <span class='ms-1'>${{ $book->physicalCopy->price }}</span>
                                        @endif
                                    @else
                                        <span class='ms-1'>N/A</span>
                                    @endif
                                    <span class='ms-1'>(in stock:
                                        {{ $book->physicalCopy && $book->physicalCopy->quantity !== null ? $book->physicalCopy->quantity : 'N/A' }})</span>
                                </p>
                                <p>E-book:
                                    @if ($book->fileCopy && $book->fileCopy->price !== null)
                                        @if ($discount)
                                            <span
                                                class="text-decoration-line-through ms-1">${{ $book->fileCopy->price }}</span>
                                            <span
                                                class='ms-1'>${{ round(($book->fileCopy->price * (100.0 - $discount->discount)) / 100, 2) }}</span>
                                            <svg class='ms-1' width="24px" height="24px" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M3.9889 14.6604L2.46891 13.1404C1.84891 12.5204 1.84891 11.5004 2.46891 10.8804L3.9889
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
                                                        stroke="#ff0000" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                    <path d="M9 15L15 9" stroke="#ff0000" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.4945 14.5H14.5035" stroke="#ff0000" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M9.49451 9.5H9.50349" stroke="#ff0000" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                            </svg><span class='text-danger'>{{ $discount->discount }}%</span>
                                        @else
                                            <span class='ms-1'>${{ $book->fileCopy->price }}</span>
                                        @endif
                                    @else
                                        <span class='ms-1'>N/A</span>
                                    @endif
                                    <a class='ms-1'
                                        title="{{ $book->fileCopy && $book->fileCopy->path ? 'Open PDF File' : 'No PDF File' }}"
                                        target="_blank"
                                        {{ $book->fileCopy && $book->fileCopy->path ? "href={$book->fileCopy->path}" : '' }}
                                        alt="PDF file">
                                        <i class="bi bi-file-earmark-fill text-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-title="{{ $book->fileCopy && $book->fileCopy->path ? 'Open PDF File' : 'No PDF File' }}"></i>
                                    </a>
                                </p>
                            </div>
                        </td>
                        <td class="align-middle col-1">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class='text-center'>
                                    <a href="{{ route('admin.manage.book.detail', ['id' => $book->id]) }}"
                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Detail" aria-label="Book Detail"
                                        data-bs-original-title="Book Detail">
                                        <i class="bi bi-info-circle text-white"></i>
                                    </a>
                                </div>
                                @if ($status)
                                    <div class='text-center' data-bs-toggle="modal"
                                        data-bs-target="#deactivateModal">
                                        <button
                                            x-on:click="$wire.bookID='{{ $book->id }}'; $wire.$refresh();$wire.setBookID('{{ $book->id }}');"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Deactivate"
                                            class="btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm"
                                            aria-label="Deactivate book" data-bs-original-title="Deactivate book">
                                            <i class="bi bi-power text-white"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class='text-center' data-bs-toggle="modal" data-bs-target="#activateModal">
                                        <button
                                            x-on:click="$wire.bookID='{{ $book->id }}'; $wire.$refresh();$wire.setBookID('{{ $book->id }}');"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Activate"
                                            class="btn btn-success ms-lg-2 mt-2 mt-lg-0 btn-sm"
                                            aria-label="Activate book" data-bs-original-title="Activate book">
                                            <i class="bi bi-power text-white"></i>
                                        </button>
                                    </div>
                                @endif
                                {{-- @if (!$book->isBought) --}}
                                <div class='text-center' data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <button
                                        x-on:click="$wire.bookID='{{ $book->id }}'; $wire.$refresh();$wire.setBookID('{{ $book->id }}');"
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                                        class='btn btn-danger ms-lg-2 mt-2 mt-lg-0 btn-sm' aria-label="Delete book"
                                        data-bs-original-title="Delete book">
                                        <i class="bi bi-trash text-white"></i>
                                    </button>
                                </div>
                                {{-- @endif --}}
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
    <div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="Deactivate modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Are you sure you want to deactivate this book?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Deactivate</button>
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
                    <p>Are you sure you want to activate this book?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Activate</button>
                </div>
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
                    <p>Are you sure you want to delete this book?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        // On modals close dispatch a customer event
        const deactivateModal = document.getElementById('deactivateModal');
        deactivateModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-book-id', {
                    bubbles: true
                }));
        });

        const activateModal = document.getElementById('activateModal');
        activateModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-book-id', {
                    bubbles: true
                }));
        });

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('hidden.bs.modal', function(event) {
            window.dispatchEvent(new CustomEvent(
                'reset-book-id', {
                    bubbles: true
                }));
        });
    </script>
</div>
