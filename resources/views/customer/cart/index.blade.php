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
                    const response = await fetch('/api/create-paypal-order', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });

                    console.log(response);
                } catch (error) {
                    console.error(error);
                }

                // const orderComponent = document.querySelector('[x-data="orderData"]');
                // const orderData = Alpine.$data(orderComponent);
                // const hardCovers = orderData.hardCovers;
                // const eBooks = orderData.eBooks;
                // const totalPrice = orderData.totalPrice;
                // const loyaltyDiscount = orderData.loyaltyDiscount;
                // const referrerDiscount = orderData.referrerDiscount;
                // const discount = orderData.discount;

                // const shipping = 0;
                // const handling = 0;
                // const insurance = 0;
                // const tax = 0;
                // const shippingDiscount = 0;
                // const items = [];
                // let itemTotal = 0;

                // hardCovers.forEach(hardCover => {
                //     itemTotal += hardCover.price * hardCover.quantity;
                //     itemTotal = Math.round(itemTotal * 100) / 100;
                //     items.push({
                //         "id": hardCover.bookID,
                //         "name": `${hardCover.bookName} - ${hardCover.bookEdition}`,
                //         "unit_amount": {
                //             "currency_code": currency,
                //             "value": hardCover.price,
                //         },
                //         "type": "Hardcover",
                //         "quantity": hardCover.quantity,
                //         "image_url": hardCover.image,
                //         "url": hardCover.url,
                //     });
                // });

                // eBooks.forEach(eBook => {
                //     itemTotal += eBook.price;
                //     itemTotal = Math.round(itemTotal * 100) / 100;
                //     items.push({
                //         "id": eBook.bookID,
                //         "name": `${eBook.bookName} - ${eBook.bookEdition}`,
                //         "unit_amount": {
                //             "currency_code": currency,
                //             "value": eBook.price,
                //         },
                //         "type": "Ebook",
                //         "quantity": 1,
                //         "image_url": eBook.image,
                //         "url": eBook.url,
                //     });
                // });

                // itemTotal = Math.round(itemTotal * 100) / 100;

                // // console.log(itemTotal, discount, totalPrice);

                // return actions.order.create({
                //     "purchase_units": [{
                //         "reference_id": crypto.randomUUID(),
                //         "amount": {
                //             "currency_code": currency,
                //             "value": totalPrice,
                //             "breakdown": {
                //                 "item_total": {
                //                     "currency_code": currency,
                //                     "value": itemTotal,
                //                 },
                //                 "tax_total": {
                //                     "currency_code": currency,
                //                     "value": tax,
                //                 },
                //                 "shipping": {
                //                     "currency_code": currency,
                //                     "value": shipping,
                //                 },
                //                 "handling": {
                //                     "currency_code": currency,
                //                     "value": handling,
                //                 },
                //                 "insurance": {
                //                     "currency_code": currency,
                //                     "value": insurance,
                //                 },
                //                 "shipping_discount": {
                //                     "currency_code": currency,
                //                     "value": shippingDiscount,
                //                 },
                //                 "discount": {
                //                     "currency_code": currency,
                //                     "value": discount,
                //                 },
                //             },
                //         },
                //         "items": items,
                //     }],
                //     intent: "CAPTURE",
                // });
            },
            onApprove(data, actions) {
                // document.getElementById('pay_form').dispatchEvent(new CustomEvent('alpine-submit', {
                //     detail: data,
                //     bubbles: true
                // }));

                // console.log(data);

                // actions.payment.execute().then(function() {
                //     window.alert('ok');
                // });
            },
            onError(err) {
                console.error(err);
            },
        }).render('#paypal_button_container');
    </script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderData', () => ({
                hardCovers: [],
                eBooks: [],
                totalPrice: 0,
                loyaltyDiscount: 0,
                referrerDiscount: 0,
                discount: 0,

                pushHardCover(hardCover) {
                    this.hardCovers.push(hardCover);
                },

                pushEBook(eBook) {
                    this.eBooks.push(eBook);
                },
            }))
        });
    </script>
@endsection
