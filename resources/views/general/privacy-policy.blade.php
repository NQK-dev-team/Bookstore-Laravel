@php
    $layout =
        auth()->check() && auth()->user()->is_admin == 1 ? 'components.layouts.admin' : 'components.layouts.customer';
@endphp

@extends($layout)


@section('preloads')
    <title>Privacy Policy</title>
    <meta name="page creator" content="Nghia Duong">
    <meta name="description" content="NQK bookstore privacy policy">
@endsection

@section('page')
    <div class='container-fluid d-flex flex-column'>
        <h1 class='mt-2 mx-auto text-center'>PRIVACY POLICY</h1>
        <hr>
        <p><strong>NQK Bookstore</strong> ("we," "us," or "our") is committed to protecting your privacy. This
            <strong>Privacy Policy</strong> explains how we collect, use, and safeguard your personal information when you
            use our website and services. By accessing or using <strong>NQK Bookstore</strong>, you consent to the
            collection and use of your information as described in this <strong>Privacy Policy</strong>.
        </p>
        <h4>1. Information We Collect</h4>
        <p><strong>1.1. Personal Information</strong>: When you create an account, place an order, or interact with our
            website, we may collect personal information such as your name, email address, shipping address, billing
            information, and contact details.</p>
        <p><strong>1.2. Usage Information</strong>: We may automatically collect information about your usage of our
            website, including your IP address, browser type, device information, pages visited, and interactions with our
            content.</p>
        <p><strong>1.3. Cookies</strong>: We use cookies and similar technologies to enhance your browsing experience,
            personalize content, analyze trends, and track user activity on our website.</p>
        <h4>2. Use of Information</h4>
        <p><strong>2.1.</strong> We use the information we collect for various purposes, including:</p>
        <ul>
            <li>Processing and fulfilling orders.</li>
            <li>Improving our products and services.</li>
            <li>Personalizing your experience.</li>
            <li>Communicating with you about promotions, offers, and updates.</li>
            <li>Analyzing website usage and trends.</li>
        </ul>
        <p><strong>2.2.</strong> We do not sell or rent your personal information to third parties without your consent,
            except as required by law or to fulfill contractual obligations.</p>
        <h4>3. Data Security</h4>
        <p><strong>3.1.</strong> We implement reasonable security measures to protect your personal information from
            unauthorized access, disclosure, alteration, or destruction.</p>
        <p><strong>3.2.</strong> However, no method of transmission over the internet or electronic storage is 100% secure.
            Therefore, we cannot guarantee absolute security.</p>
        <h4>4. Third-Party Services</h4>
        <p><strong>4.1.</strong> We may use third-party services, such as payment processors and analytics providers, to
            facilitate our operations and improve our services.</p>
        <p><strong>4.2.</strong> These third parties may have their own privacy policies governing the use of your
            information, which we encourage you to review.</p>
        <h4>5. Children's Privacy</h4>
        <p><strong>5.1.</strong> <strong>NQK Bookstore</strong> is not intended for children under the age of 13. We do not
            knowingly collect personal information from children without parental consent.</p>
        <h4>6. Your Choices</h4>
        <p><strong>6.1.</strong> You can update or modify your account information by logging into your <strong>NQK
                Bookstore</strong> account.</p>
        <p><strong>6.2.</strong> You may opt-out of receiving promotional emails or newsletters by following the unsubscribe
            instructions included in the emails.</p>
        <h4>7. Changes to Privacy Policy</h4>
        <p><strong>7.1.</strong> We reserve the right to update or revise this <strong>Privacy Policy</strong> at any time.
            Any changes will be posted on this page with the updated <strong>Last Updated</strong> date.</p>
        <p><strong>7.2.</strong> Continued use of our website after changes are posted constitutes your acceptance of the
            revised <strong>Privacy Policy</strong>.</p>
        <p>If you have any questions, concerns, or feedback regarding this <strong>Privacy Policy</strong>, please contact
            us at <strong>nqk.demo@gmail.com</strong>.</p>
        <p>Thank you for trusting <strong>NQK Bookstore</strong> with your personal information. Happy reading!</p>
    </div>
@endsection

@section('postloads')
@endsection
