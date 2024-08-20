@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Return Policy</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <h5>Last updated: 20-08-2024</h5>
                At {{ config('app.name') }}, we want you to be completely satisfied with your purchase.
                If you are not entirely happy with your purchase, we're here to help.
                Please read our Return Policy carefully to understand your rights and obligations.
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-10 pb-3">
                <ul>
                    <ol>
                        <h4>1. Returns</h4>
                        If you are not satisfied with your purchase, you may return it within 15 days from the date you received it.
                        To be eligible for a return, your item must be:
                        <ul>
                            <li><strong>Unused and in the same condition that you received it.</strong></li>
                            <li><strong>In the original packaging with all tags and labels attached.</strong></li>
                            <li><strong>Accompanied by the receipt or proof of purchase.</strong></li>
                        </ul>
                    </ol>
                    <ol>
                        <h4>2. How to Initiate a Return</h4>
                        To initiate a return, please follow these steps:
                        <ul>
                            <li><strong>Contact Us:</strong> Email us at <a href="info@desinaumova.com">info@desinaumova.com</a> with your order number and reason for the return.
                                We will provide you with a Return Authorization Number (RAN) and instructions on where to send your item.
                            </li>
                            <li>
                                <strong>Prepare the Package: </strong>
                                Place the item securely in its original packaging, along with your receipt or proof of
                                purchase, and clearly write the RAN on the outside of the package.
                            </li>
                            <li>
                                <strong>Ship the Return: </strong>
                                Mail the return package to the address provided in our return instructions. You are responsible for the
                                shipping costs unless the item is defective or we made an error with your order.
                            </li>
                        </ul>
                        <strong>Note: </strong> We recommend using a trackable shipping method, as we cannot be responsible for items lost during return shipping.
                    </ol>
                    <ol>
                        <h4>3. Refunds</h4>
                        Once we receive your returned item, we will inspect it and notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund based on the condition of the item.
                        <br /><br />
                        <p><strong>Approved Refunds:</strong> If your return is approved, we will process your refund to your original method of payment. You will receive the credit within a certain number of days, depending on your card issuer's policies.</p>
                        <p><strong>Partial Refunds:</strong> In certain situations, only partial refunds may be granted, such as items not in their original condition, damaged, or missing parts for reasons not due to our error.</p>
                        <p><strong>Non-Refundable Items:</strong> Items marked as "Final Sale" are not eligible for a refund.</p>
                    </ol>
                    <ol>
                        <h4>4. Return Shipping Costs</h4>
                        <br />
                        <p><strong>Customer Responsibility:</strong> Unless the return is due to a defect or an error on our part, you are responsible for paying the shipping costs for returning your item.</p>
                        <p><strong>Refund of Shipping Costs:</strong> Shipping costs are non-refundable. If you receive a refund, the original cost of shipping will be deducted from your refund.</p>
                    </ol>
                    <ol>
                        <h4>5. Late or Missing Refunds</h4>
                        If you haven’t received a refund yet, first check your bank account again. Then contact your credit card company; it may take some time before your refund is officially posted.
                        If you’ve done all of this and you still have not received your refund, please contact us at <a href="info@desinaumova.com">info@desinaumova.com</a>.
                    </ol>
                    <ol>
                        <h4>6. Contact Us</h4>
                        If you have any questions about our Return Policy, please contact us:
                        <br /><br />
                        {{ config('app.name') }}<br />
                        <a href="info@desinaumova.com">info@desinaumova.com</a>
                    </ol>
                </ul>
            </div>
        </div>
    </div>
@endsection
