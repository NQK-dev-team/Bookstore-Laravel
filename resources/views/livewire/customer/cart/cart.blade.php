<div class='w-100 h-100 d-flex'>
    <form class='bg-white border border-3 rounded m-auto p-3 d-flex flex-column cart-form'
        @if ($cartDetail) wire:poll.10s="updateCart" @endif>
        <h1 class='mt-2 fs-2'>Shopping Cart</h1>
        <hr>
        <div class='row flex-grow-1 overflow-hidden' wire:poll.visible.10s="updateCart">
            <div class='col-lg-8 col-12 d-flex flex-column'>
                <div class='flex-column mb-4 d-flex'>
                    <h4>E-books</h4>
                    <div class="w-100 bg-white border rounded border-3 overflow-y-auto overflow-x-hidden item-container">
                    </div>
                </div>

                <div class='flex-column d-flex'>
                    <h4>Hardcovers</h4>
                    <div class='mb-2'>
                        <label class='fw-bold form-label' for="physicalDestination">Delivery Address:&nbsp;</label>
                        <input class='form-control border-3'></input>
                    </div>
                    <div
                        class="w-100 bg-white border rounded border-3 overflow-y-auto overflow-x-hidden mb-lg-4 item-container">
                    </div>
                </div>
            </div>
            <div class='col-lg-4 col-12 mt-3 mt-lg-0'>
                <div class='border border-3 rounded py-2 px-3 mb-5'>
                    <h4 class='mt-2'>Price Detail</h4>
                    <p>Total Before Discount Coupons:&nbsp;<span class='fw-medium'></span></p>
                    <p>Total After Discount Coupons:&nbsp;<span class='fw-medium'></span></p>
                    <p>Loyalty Discount:&nbsp;<span class='fw-medium'>{{ $loyalty ? $loyalty . '%' : 0 }}</span></p>
                    <p>Referrer Discount:&nbsp;<span class='fw-medium'>{{ $refer ? $refer . '%' : 0 }}</span></p>
                    <p>Total Discount:&nbsp;<span class='fw-medium'></span></p>
                    <h4>Final Price:&nbsp;<span class='fw-medium'></span></h4>
                    <hr>
                    <button type="submit"
                        class="btn btn-primary customized-button text-white mb-3 w-100 mt-3 fs-4">Cash On
                        Delivery</button>
                    <div id='paypal_button_container'></div>
                </div>
            </div>
        </div>
    </form>
</div>
