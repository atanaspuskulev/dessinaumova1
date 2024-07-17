@extends('layouts.front')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Payment Completed</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3 mb-4 p-5">
        Dear {{ $order->payer_name }},<br /><br />

        Thank you for your purchase! We are delighted to inform you that your payment has been successfully processed
        and your order has been received.<br /><br />

        Your chosen artworks are now being prepared for shipment and will be sent to you shortly.
        You can expect to receive a confirmation email with tracking details once your order has been dispatched.<br /><br />

        In the meantime, should you have any questions, concerns, or special requests, please do not hesitate to
        contact us. We are here to assist you and ensure your complete satisfaction with your purchase.<br /><br />

        Thank you for choosing our service. We hope you enjoy your new artworks and look forward to serving you again
        in the future.<br /><br />

        Best regards,<br /><br />

        Desi Naumova<br />
        info@dessinaumova.com<br />
    </div>
@endsection
