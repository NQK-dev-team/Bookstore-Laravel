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
    {{-- <script
        src="https://www.paypal.com/sdk/js?client-id=AeJzcuBeYdWuSATJhEg4Y6VELgzJlgrjby07Upgt5V88gwHWeFeeBdJi121zROOe0MaOIvQ6ACBvG0Km&currency=USD">
    </script>
    <script>
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
            createOrder: function(data, actions) {
                if (placeOrder())
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: $('#finalPrice').text().substring(1)
                            }
                        }]
                    });
                return actions.order.create(null);
            },
            onApprove(data, actions) {
                $("#cartForm").submit();
            }
        }).render('#paypal_button_container')
    </script> --}}
@endsection
