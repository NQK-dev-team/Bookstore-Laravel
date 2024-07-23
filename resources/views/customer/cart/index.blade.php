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
@endsection

@section('postloads')
    @livewireScripts
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID', '') }}&currency={{ env('PAYPAL_CURRENCY', 'USD') }}&components=buttons"
        data-sdk-integration-source="developer-studio"></script>
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
                try {
                    document.getElementById('pay_form').dispatchEvent(new CustomEvent('alpine-stop-polling', {
                        bubbles: true
                    }));

                    const response = await fetch('/api/create-paypal-order', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });

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

                    const order = await response.json();
                } catch (error) {
                    console.error(error);
                }

                // document.getElementById('pay_form').dispatchEvent(new CustomEvent('alpine-submit', {
                //     bubbles: true
                // }));
            },
            async onError(err) {
                console.error(err);

                document.getElementById('pay_form').dispatchEvent(new CustomEvent('alpine-stop-polling', {
                    bubbles: true
                }));
            },
            async onCancel() {
                document.getElementById('pay_form').dispatchEvent(new CustomEvent('alpine-stop-polling', {
                    bubbles: true
                }));
            }
        }).render('#paypal_button_container');
    </script>
@endsection
