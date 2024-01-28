<x-mail::message>
# You have new order

<h1>New order details:</h1>

<b>Order ID:</b> {{ $order->order_id }}<br />
<b>Status:</b> {{ $order->status }}<br />
<b>From:</b> {{ $order->payer_name }}<br />
<b>Email:</b> {{ $order->payer_email }}<br />
<b>Phone:</b> {{ $order->payer_phone }}<br />
<b>Country:</b> {{ $order->payer_country }}<br />
<b>Country Code:</b> {{ $order->payer_country_code }}<br />
<b>State:</b> {{ $order->payer_state }}<br />
<b>City:</b> {{ $order->payer_city }}<br />
<b>Zip/Postal code:</b> {{ $order->payer_zip }}<br />
<b>Address:</b> {{ $order->payer_address }}
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
                <td>{{ $item->product->price }} &euro;</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="border-start">
            <td colspan="2" align="right">
                <h3>Total: {{ $order->amount }} {{ $order->currency }}</h3>
            </td>
        </tr>
    </tfoot>
</table>
</x-mail::message>
