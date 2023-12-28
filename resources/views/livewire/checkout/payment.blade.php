@section('head_js')
    <script src="https://www.paypal.com/sdk/js?client-id=Ae3ujpfWtOaG1KPX85KmFMYsoIbpD2BmlrI4jimocn-K15V-zAWZFS5bEN8AsF6lLgKWQAMXAd-Y1aX9&currency=EUR"></script>
    <script>
        const orderInfo = JSON.parse('{!! $order !!}');

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    application_context: {
                        brand_name : 'Desi Naumova',
                        user_action : 'PAY_NOW',
                        locale: 'en-US',
                        merchant_preferences: {
                            note_to_merchant: '{!! $noteToMerchant !!}'
                        }
                    },
                    purchase_units: orderInfo.purchase_units,
                });
            },
            onApprove: function(data, actions) {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                return actions.order.capture().then(function(details) {

                });
            },
            onCancel: function(data) {

            }
        }).render('#paypal-button-container');
    </script>
@endsection

<div>
    {{ $order }}
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <h1>Payment</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3 mb-4">
        <div id="paypal-button-container"></div>
    </div>
</div>
