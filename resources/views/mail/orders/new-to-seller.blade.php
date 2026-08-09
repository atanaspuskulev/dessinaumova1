<x-mail::message>
# You have new order

<h1>New order details:</h1>

<b>Order ID:</b> {{ $order->order_id }}<br />
<b>Status:</b> {{ $order->status }}<br />
<b>From:</b> {{ $order->payer_name }}<br />
<b>Email:</b> {{ $order->payer_email }}<br />
<b>Phone:</b> {{ $order->payer_phone }}<br />
<b>City:</b> {{ $order->payer_city }}<br />
<b>Zip/Postal code:</b> {{ $order->payer_zip }}<br />
<b>Address:</b> {{ $order->payer_address }}<br />
<b>Additional information:</b> {{ $order->additional_information ?? 'N/A' }}
@if($order->delivery_method)
<br /><b>Delivery method:</b> {{ ucfirst($order->delivery_method) }}
@endif
@if($order->payment_method)
<br /><b>Payment method:</b> {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'PayPal' }}
@endif
<hr>
<h2>Order Items:</h2>
<table class="table table-striped" style="width:100%;">
    <thead>
        <tr>
            <th align="left">Product</th>
            <th align="left">Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>
                    <a target="_new" href="{{ route('front.product_view', ['category_slug' => $item->product->category->slug, 'product_slug' => $item->product->slug]) }}">{{ $item->product->title }}</a>
                </td>
                <td>@price($item->price, $item->currency)</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="border-start">
            <td colspan="2" align="right">
                <h3>Total: @price($order->amount, $order->currency)</h3>
            </td>
        </tr>
    </tfoot>
</table>
</x-mail::message>
