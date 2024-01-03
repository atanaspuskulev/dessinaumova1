@section('head_js')
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=EUR">
    </script>
    <script>
        let paypalBrandName = '{!! $paypalBrandName !!}';
        let paypalSuccessUrl = '{{ route('front.payment.order.success') }}';
        let paypalCancelUrl = '{{ route('front.payment.order.cancel') }}';
        let orderCreateUrl = '{{ route('front.payment.order.create') }}';
        let orderUpdateUrl = '{{ route('front.payment.order.update') }}';
        let orderInfo = JSON.parse('{!! $order !!}');
    </script>

    <script src="{{ asset('assets/js/payment.js') }}"></script>
@endsection

<div>
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
