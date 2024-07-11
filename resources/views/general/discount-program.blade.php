@php
    $layout =
        auth()->check() && auth()->user()->is_admin == 1 ? 'components.layouts.admin' : 'components.layouts.customer';
@endphp

@extends($layout)

@section('preloads')
    <title>Discount Program</title>
    <link rel='stylesheet' href='{{ asset('assets/css/general/about-us.css') }}'>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="NQK bookstore discount program">
@endsection

@section('page')
    <div class='container-fluid d-flex flex-column'>
        <h1 class='mt-2 mx-auto text-center'>DISCOUNT PROGRAM</h1>
        <hr>
        <h4>1. Loyalty Program</h4>
        <p><strong>{{ env('STORE_POINT_CONVERSION_RATE', '10') }}%</strong> of the total order price will be converted to
            accumulating points.</p>
        <div class='overflow-x-auto w-100 border rounded'>
            <table class="table table-bordered w-100 m-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Point</th>
                        <th scope="col">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerDiscounts as $index => $discount)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class='text-nowrap'>{{ $discount->name }}</td>
                            <td>{{ $discount->customerDiscount->point }}</td>
                            <td>{{ $discount->discount }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br><br>
        <h4>2. Referrer Program</h4>
        <div class='overflow-x-auto w-100 border rounded'>
            <table class="table table-bordered w-100 m-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Number Of People</th>
                        <th scope="col">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referrerDiscounts as $index => $discount)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class='text-nowrap'>{{ $discount->name }}</td>
                            <td>{{ $discount->referrerDiscount->number_of_people }}</td>
                            <td>{{ $discount->discount }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('postloads')
@endsection
