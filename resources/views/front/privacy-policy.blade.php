@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Privacy Policy</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <h5 class="mb-3">Last updated: 20-08-2024</h5>
                <strong>{{ config('app.name') }}</strong> ("we", "us", "our") operates the website {{ config('app.url') }} ("Website").
                This Privacy Policy describes how we collect, use, and share information when you visit our
                Website and make a purchase from us.
                By using our Website, you agree to the collection and use of information in accordance with this policy.
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <ol>
                    <li><a href="#information-we-collect">Information We Collect</a></li>
                    <li><a href="#your-information">How We Use Your Information</a>
                    <li><a href="#sharing-information">Sharing Your Information</a></li>
                    <li><a href="#cookies-and-tracking">Cookies and Tracking Technologies</a></li>
                    <li><a href="#security">Security</a></li>
                    <li><a href="#your-rights">Your Rights</a></li>
                    <li><a href="#external-links">Links to Other Websites</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="information-we-collect">1. Information We Collect</h3>
                We collect the following types of information to fulfill your orders and improve your shopping experience:
                <ul>
                    <li>
                        <strong>Personal Information: </strong>
                        When you place an order, we collect personal information such as your name, email address,
                        shipping address, and payment information. This information is necessary to process and deliver
                        your orders.
                    </li>
                    <li>
                        <strong>Log Data:</strong>
                        Like many websites, we collect information that your browser sends whenever you visit our
                        Website ("Log Data").
                        This may include information such as your computer's Internet Protocol ("IP") address,
                        browser type, browser version, the pages of our Website that you visit, the time and date of
                        your visit, the time spent on those pages, and other statistics.
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 border-bottom pb-3">
                <h3 id="your-information">2. How We Use Your Information</h3>
                We use the information we collect for the following purposes:
                <ul>
                    <li><strong>Order Processing:</strong> To process and deliver your orders, including sending you emails to confirm your order status and shipping details.</li>
                    <li><strong>Customer Support:</strong> To provide customer support and respond to your inquiries.</li>
                    <li><strong>Improving Our Website:</strong> To analyze trends, usage, and activities on our Website to improve its functionality and user experience.</li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3 border-bottom">
                <h3 id="sharing-information">3. Sharing Your Information</h3>
                We do not sell, trade, or otherwise transfer your personal information to outside parties, except as necessary to fulfill your order or comply with the law. This includes:
                <ul>
                    <li>
                        <strong>Service Providers: </strong>We may share your information with third-party service
                        providers who assist us in operating our Website,
                        conducting our business, or servicing you (e.g., payment processors, shipping companies),
                        as long as those parties agree to keep your information confidential and secure.
                    </li>
                    <li><strong>Legal Compliance: </strong>We may disclose your information if required to do so by law or in response to valid requests by public authorities (e.g., a court or a government agency).</li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3 border-bottom">
                <h3 id="cookies-and-tracking">4. Cookies and Tracking Technologies</h3>
                Our Website uses cookies to enhance your browsing experience.
                Cookies are small data files that are placed on your computer or mobile device when you visit our Website.
                We use cookies for the following purposes:
                <ul>
                    <li>
                        To recognize you when you return to our Website.
                    </li>
                    <li>To remember your preferences and shopping cart contents.</li>
                    <li>To analyze Website usage and performance.</li>
                </ul>
                You can choose to disable cookies through your browser settings; however, this may affect your ability to use certain features of our Website.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3 border-bottom">
                <h3 id="security">5. Security</h3>
                We take the security of your personal information seriously and use appropriate measures to protect it. However, please be aware that no method of transmission over the Internet, or method of electronic storage, is 100% secure, and we cannot guarantee absolute security.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3 border-bottom">
                <h3 id="your-rights">6. Your Rights</h3>
                Depending on your location, you may have certain rights regarding your personal information, such as the right to:
                <ul>
                    <li><strong>Access:</strong> Request a copy of the information we hold about you.</li>
                    <li><strong>Rectification:</strong> Request that we correct any inaccuracies in your information.</li>
                    <li><strong>Deletion:</strong> Request that we delete your personal information, subject to certain legal requirements.</li>
                    <li><strong>Withdrawal of Consent:</strong> Withdraw your consent to the processing of your information, where applicable.</li>
                </ul>
                To exercise any of these rights, please contact us using the information provided below.
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3">
                <h3 id="external-links">7. Links to Other Websites</h3>
                Our Website may contain links to third-party websites that are not operated by us. If you click on a third-party link, you will be directed to that third party's site.
            </div>
        </div>
    </div>
@endsection
