@extends('components.layouts.customer')

@section('preloads')
    <title>Shopping Cart</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="Shopping cart of customers of NQK Bookstore">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/cart/style.css') }}">
    @livewireStyles
@endsection

@section('page')
    @livewire('customer.cart.cart')
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="Error modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Error</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p id="error_message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="emptyModal" tabindex="-1" aria-labelledby="Cart empty modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Your cart is empty.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="Cart purchase modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Notice</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <p>Thank you for your purchase! Your cart has been successfully processed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('postloads')
    @livewireScripts
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID', '') }}&currency={{ env('PAYPAL_CURRENCY', 'USD') }}&components=buttons"
        data-sdk-integration-source="developer-studio"></script>
    <script>
        document.getElementById('errorModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('error_message').innerHTML = '';
        });
    </script>
    <script>
        const currency = '{{ env('PAYPAL_CURRENCY', 'USD') }}';
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'rect',
                label: 'pay',
                height: 55,
                borderRadius: 10,
                disableMaxWidth: true
            },
            async createOrder() {
                document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                    'alpine-toggle-stop-polling', {
                        bubbles: true
                    }));

                try {
                    const response = await fetch('/api/create-paypal-order', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });

                    if (response.status === 404) {
                        const modal = new bootstrap.Modal('#emptyModal');
                        modal.toggle();

                        document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                            'alpine-toggle-stop-polling', {
                                bubbles: true
                            }));
                    }

                    const order = await response.json();
                    return order.id;
                } catch (error) {
                    console.error(error);
                }
            },
            async onApprove(data, actions) {
                try {
                    const response = await fetch(`/api/capture-paypal-order/${data.orderID}`, {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });

                    if (response.status === 500) {
                        document.getElementById('error_message').innerHTML =
                            'The server cannot process your cart. Please try again.';
                        const modal = new bootstrap.Modal('#errorModal');
                        modal.toggle();

                        document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                            'alpine-toggle-stop-polling', {
                                bubbles: true
                            }));
                    }

                    const orderData = await response.json();

                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you message

                    const errorDetail = orderData?.details?.[0]

                    if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                        // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                        // recoverable state, per
                        // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/

                        return actions.restart();
                    } else {
                        if (errorDetail) {
                            // (2) Other non-recoverable errors -> Show a failure message
                            throw new Error(`${errorDetail.description} (${orderData.debug_id})`);

                            document.getElementById('error_message').innerHTML = orderData.message;
                            const modal = new bootstrap.Modal('#errorModal');
                            modal.toggle();
                        } else if (!orderData.purchase_units) {
                            throw new Error(JSON.stringify(orderData));

                            document.getElementById('error_message').innerHTML = `Paypal order content error.`;
                            const modal = new bootstrap.Modal('#errorModal');
                            modal.toggle();
                        } else {
                            // (3) Successful transaction

                            const modal = new bootstrap.Modal('#purchaseModal');
                            modal.toggle();
                        }
                        document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                            'alpine-toggle-stop-polling', {
                                bubbles: true
                            }));
                    }
                } catch (error) {
                    console.error(error);
                }
            },
            async onError(err) {
                console.error(err);

                document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                    'alpine-toggle-stop-polling', {
                        bubbles: true
                    }));
            },
            async onCancel() {
                document.getElementById('pay_form').dispatchEvent(new CustomEvent(
                    'alpine-toggle-stop-polling', {
                        bubbles: true
                    }));
            }
        }).render('#paypal_button_container');
    </script>
@endsection
