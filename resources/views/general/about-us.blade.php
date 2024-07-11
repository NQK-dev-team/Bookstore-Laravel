@php
    $layout =
        auth()->check() && auth()->user()->is_admin == 1 ? 'components.layouts.admin' : 'components.layouts.customer';
@endphp

@extends($layout)


@section('preloads')
    <title>About Us</title>
    <link rel='stylesheet' href='{{ asset('assets/css/general/about-us.css') }}'>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="About NQK bookstore">
@endsection

@section('page')
    <div class='container-fluid d-flex flex-column h-100'>
        <h1 class='mt-2 mx-auto text-center'>ABOUT NQK BOOKSTORE</h1>
        <hr>
        <h4>1. About Us</h4>
        <p>Welcome to the captivating world of literature at our online book emporium! Dive into a realm where stories come
            alive, characters become companions, and knowledge is boundless. Our bookstore is a sanctuary for bibliophiles,
            offering a treasure trove of genres, from gripping thrillers to heartwarming romances, thought-provoking
            non-fiction to whimsical fantasies.</p>
        <p>Whether you're an avid reader seeking your next literary adventure or a curious soul eager to explore new
            narratives, our virtual shelves are brimming with captivating titles waiting to be discovered. Immerse yourself
            in the enchanting pages of timeless classics, discover contemporary masterpieces, or uncover hidden gems
            recommended by our passionate community of readers.</p>
        <p>We aim to ignite your passion for reading and make every visit to our bookstore a delightful journey. Join us in
            celebrating the magic of storytelling and embark on a literary odyssey unlike any other. Welcome to a world of
            endless possibilities — welcome to our book haven!</p>
        <h4>2. Contact Us</h4>
        <p>Email: <strong>nqk.demo@gmail.com</strong></p>
        <p>Phone: <strong>(+84)012-345-6789</strong></p>
        <p>Address: <strong>268 Lý Thường Kiệt, Phường 14, Quận 10, Thành phố Hồ Chí Minh, Vietnam</strong></p>
        <div class='mb-3 flex-grow-1 w-100 d-flex flex-column'>
            <iframe class='image border border-1 rounded border-secondary'
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d489.93901869949366!2d106.65840844905175!3d10.772031193806711!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2sHo%20Chi%20Minh%20City%20University%20of%20Technology%20(HCMUT)!5e0!3m2!1sen!2sus!4v1712248396230!5m2!1sen!2sus"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <figure class='image d-flex flex-column'>
                <img alt="HCMUT front gate" src='{{ asset('assets/images/front-gate.jpg') }}'
                    class='w-100 flex-grow-1 border-1 rounded border-secondary border mt-4'>
                <figcaption class='mx-auto fw-medium'>HCMUT front gate</figcaption>
            </figure>
        </div>
        <h4>3. Disclaimer</h4>
        <p>This website is for learning purpose only, no commercial usage intended!</p>
    </div>
@endsection

@section('postloads')
@endsection
