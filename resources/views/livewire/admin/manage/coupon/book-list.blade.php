<div class="modal-body d-flex flex-column">
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
    <div class="mt-2 d-flex flex-lg-row flex-column">
        @livewire('admin.manage.book.category')
        @livewire('admin.manage.book.author', ['breakpoint' => 'lg'])
        @livewire('admin.manage.book.publisher', ['breakpoint' => 'lg'])
    </div>
    <div class="mt-2">
        <div class="d-flex align-items-center">
            <p class="mb-0 me-2">Show</p>
            <div>
                <select id="book_entry_select" class="form-select form-select-sm pointer" aria-label="Entry selection"
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
            <colgroup>
                <col style="width:50px;">
            </colgroup>
            <thead>
                <tr wire:key={{ uniqid() }}>
                    <th scope="col" class='text-center align-middle'><input
                            type="checkbox" id="checkAll" style="width:1rem; height:1rem;" class="pointer"
                            x-on:change="if($el.checked){
                                    checkAll();
                                } else{
                                    unCheckAll();
                                }">
                    </th>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Edition</th>
                    <th scope="col">Author</th>
                    <th scope="col">Category</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`);
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));">
                @foreach ($books as $index => $book)
                    <tr wire:key={{ uniqid() }}>
                        <td class="align-middle col text-center" x-init="checkAllSelected();">
                            <input type="checkbox" id="checkBook_{{ $book->id }}" class="pointer"
                                style="width:1rem; height:1rem;" value={{ $book->id }} name="select-books-applied"
                                x-on:change="if($el.checked){
                                    $wire.checkBook('{{ $book->id }}');
                                    checkAllSelected();
                                } else{
                                    $wire.unCheckBook('{{ $book->id }}');
                                    document.getElementById('checkAll').checked = false;
                                }"
                                @if (in_array($book->id, $selectedBooks)) checked @endif
                                data-checked="{{ in_array($book->id, $originalSelectedBooks) ? 1 : 0 }}">
                        </td>
                        <td class="align-middle col">{{ $offset * $limit + $index + 1 }}</td>
                        <td class="col-2 align-middle">
                            <div style="width:200px;">{{ $book->name }}</div>
                        </td>
                        <td class="align-middle text-nowrap">
                            {{ $book->edition }}
                        </td>
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
                                            data-bs-title="{{ getCategoryDescription($category) }}"
                                            x-init="const tooltipTriggerList = document.querySelectorAll(`[data-bs-toggle='tooltip']`);
                                            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));"></i></p>
                                @endforeach
                            </div>
                        </td>
                        <td class="align-middle col-1 text-nowrap">
                            <div class="d-flex flex-column">
                                <p>{{ $book->publisher }}</p>
                                <p class="text-nowrap">{{ $book->publication_date }}</p>
                            </div>
                        </td>
                        <td class="align-middle col-1 text-nowrap">
                            <span
                                class='text-warning'>{!! displayRatingStars($book->average_rating) !!}</span>&nbsp;({{ $book->average_rating }})
                        </td>
                        <td class="align-middle col-1">
                            <div>
                                <a href="{{ route('admin.manage.book.detail', ['id' => $book->id]) }}" target="_blank"
                                    class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Detail" aria-label="Book Detail"
                                    data-bs-original-title="Book Detail">
                                    <i class="bi bi-info-circle text-white"></i>
                                </a>
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
            <p>{{ $total ? (($offset + 1) * $limit > $total ? $total : ($offset + 1) * $limit) : 0 }}
            </p>
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
    <hr>
    <div class="d-flex align-items-center justify-content-end">
        <button type="button" class="btn btn-light border border-dark me-2"
            x-on:click="$wire.resetSelection();
            const inputs=document.querySelectorAll('input[type=checkbox][name=select-books-applied]');
            inputs.forEach(input => {
                if(input.getAttribute('data-checked') === '1'){
                    input.checked = true;
                } else{
                    input.checked = false;
                }
            });
            checkAllSelected();">Reset</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
