@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Terms Of Use</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <h5>Last updated: 20-08-2004</h5>
                Welcome to {{ config('app.name') }} Website. ("we", "us", "our").
                By accessing or using our website at {{ config('app.url') }} ("Website"),
                you agree to comply with and be bound by the following terms and conditions ("Terms of Use").
                Please read these Terms of Use carefully
                before using our Website. If you do not agree with these Terms, you should not use our Website.
                <ul class="mt-4">
                    <ol>
                        <h4>1. Acceptance of Terms</h4>
                        By accessing or using our Website, you agree to be bound by these Terms of Use, as well as our Privacy Policy and any other policies or guidelines that may be applicable. These Terms apply to all visitors, users, and others who access or use the Website.
                    </ol>
                    <ol>
                        <h4>2. Use of the Website</h4>
                        You agree to use our Website only for lawful purposes and in
                        accordance with these Terms of Use. You are prohibited from using our Website:
                        <ul>
                            <li><h6>For any unlawful purpose.</h6></li>
                            <li><h6>To solicit others to perform or participate in any unlawful acts.</h6></li>
                            <li><h6>To violate any international, federal, or local regulations, rules, laws, or ordinances.</h6></li>
                            <li><h6>To infringe upon or violate our intellectual property rights or the intellectual property rights of others.</h6></li>
                            <li><h6>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability.</h6></li>
                            <li><h6>To submit false or misleading information.</h6></li>
                            <li><h6>To upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Website or any related website.</h6></li>
                            <li><h6>To collect or track the personal information of others.</h6></li>
                            <li><h6>To spam, phish, pharm, pretext, spider, crawl, or scrape.</h6></li>
                            <li><h6>For any obscene or immoral purpose.</h6></li>
                            <li><h6>To interfere with or circumvent the security features of the Website or any related website.</h6></li>
                        </ul>
                    </ol>
                    <ol>
                        <h4>3. Product Information and Availability</h4>
                        All descriptions of products and product pricing on our Website are subject to change at any time
                        without notice, at our sole discretion. We reserve the right to discontinue any product at any time.
                        We do not warrant that the quality of any products purchased by you will meet your expectations.
                    </ol>
                    <ol>
                        <h4>4. Orders and Payment</h4>
                        <ul>
                            <li><strong>Order Acceptance:</strong> We reserve the right to refuse any order you place with us. We may limit or cancel quantities purchased per person, per household, or per order at our discretion.</li>
                            <li><strong>Payment:</strong> All payments must be made at the time of purchase. We accept payment via Paypal Fastpay and Paypal CreditCard processing. By providing your payment information, you authorize us to charge the amount specified for the order.</li>
                            <li><strong>Pricing: </strong>Prices for our products are subject to change without notice. We reserve the right to correct any pricing errors at any time.</li>
                        </ul>
                    </ol>
                    <ol>
                        <h4>5. Shipping and Delivery</h4>
                        We aim to ship products within 1-5 business days after receiving your order. Delivery times may vary depending on your location and shipping method. We are not responsible for any delays in shipping caused by third-party carriers or factors beyond our control.
                    </ol>
                    <ol>
                        <h4>6. Returns and Refunds</h4>
                        If you are not satisfied with your purchase, you may return the product within 15 days of receipt
                        for a refund or exchange, subject to our <a href="{{ route('front.return_policy') }}">Return Policy</a>.
                        To initiate a return, please contact us at <a href="mailto:info@desinaumova.com">info@desinaumova.com</a>.
                        Return shipping costs are the responsibility of the customer, unless the product is defective or we
                        made an error in the order.
                    </ol>
                    <ol>
                        <h4>7. Intellectual Property Rights</h4>
                        All content on our Website, including text, graphics, logos, images, and software,
                        is the property of {{ config('app.name') }} Website owner and its content
                        suppliers and is protected by international copyright, trademark, and other intellectual
                        property laws. You may not use, reproduce, or distribute any content from our
                        Website without our express written permission.
                    </ol>
                    <ol>
                        <h4>8. Limitation of Liability</h4>
                        To the fullest extent permitted by law, {{ config('app.name') }} shall not be liable for any direct, indirect,
                        incidental, special, or consequential damages resulting from the use or inability to use our
                        Website or products, even if we have been advised of the possibility of such damages.
                        This includes, but is not limited to, damages for loss of profits, data, or other intangibles.
                    </ol>
                    <ol>
                        <h4>9. Indemnification</h4>
                        You agree to indemnify, defend, and hold harmless {{ config('app.name') }} and our affiliates, owners, employees,
                        and agents from and against any and all claims, liabilities, damages, losses, and expenses, including legal fees,
                        arising out of or in any way connected with your use of the Website or breach of these Terms of Use.
                    </ol>
                    <ol>
                        <h4>10. Governing Law</h4>
                        These Terms of Use shall be governed by and construed in accordance with the laws of
                        Bulgarian Court, without regard to its conflict of law principles.
                        Any disputes arising from these Terms or your use of the Website shall be resolved in
                        the courts located in Bulgarian Court.
                    </ol>
                    <ol>
                        <h4>11. Changes to These Terms</h4>
                        We reserve the right to update or modify these Terms of Use at any time without prior notice. Your continued use of the Website following the posting of changes constitutes your acceptance of those changes. We encourage you to review these Terms periodically for any updates.
                    </ol>
                    <ol>
                        <h4>12. Contact Information</h4>
                        If you have any questions about these Terms of Use, please contact us at:<br /><br />
                        <a href="info@desinaumova.com">info@desinaumova.com</a>
                    </ol>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">

            </div>
        </div>
    </div>
@endsection
