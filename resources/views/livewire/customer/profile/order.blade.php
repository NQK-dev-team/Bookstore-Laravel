<div class='d-flex flex-column overflow-auto'>
    <p>Current Accummulated Points:&nbsp;<span class='fw-bold'></span></p>
    <p>Loyalty Discount:&nbsp;<span class='fw-bold'></span></p>
    <p>Users Referenced:&nbsp;<span class='fw-bold'></span></p>
    <p>Referrer Discount:&nbsp;<span class='fw-bold'></span></p>
    <div>
        <form class="d-flex align-items-center w-100 mt-2" role="search">
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

            <input id="search_order" class="form-control me-2 search_form" type="search"
                placeholder="Search by order code" aria-label="Search">
        </form>

        <label for="orderDateInput" class="form-label fw-medium mt-3">Order Date:</label>
        <input autocomplete="off" type="date" class="form-control" id="orderDateInput" style="max-width:500px;">
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
            </tbody>
        </table>
    </div>

    @if ($order_id)
        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="Order modal">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class='d-flex'>
                            <h2 class="modal-title fs-5">Order:&nbsp;</h2>
                            <h2 class="modal-title fs-5 fw-normal"></h2>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <p>Order Time:&nbsp;<span class='fw-medium'></span></p>
                        <p>Total Discount:&nbsp;<span class='fw-medium'></span></p>
                        <p>Total Price:&nbsp;<span class='fw-medium'></span></p>
                        <div class='mt-3'>
                            <div class='flex-column'>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='flex-column mt-3'>
                                <h5>Hardcovers</h5>
                                <p class='fw-medium'>Delivery Address:&nbsp;</p>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // const modal = new bootstrap.Modal('#orderModal');
            // modal.toggle();
        </script>
    @endif
</div>
