<x-mail::message>
# Order: {{ $order->order_id }}

Dear {{ $order->payer_name }},

Your order at {{ config('app.name') }} was successfully
completed. Below you will find detailed information for your order.

<b>You will also find your Invoice included with this message.</b>

<x-mail::table>
    | Product       | Price         | Currency  |
    | ------------- |:-------------:| --------:|
    @foreach($order->items as $item)
        | {{ $item->product->title }} | {{ $item->product->price }} | {{ $order->currency }} |
    @endforeach
    | Total      | {{ $order->amount }} | {{ $order->currency }} |
</x-mail::table>

<br /><br />
You can download your <a target="_new" href="{{ $invoice['url'] }}">invoice from here</a>.<br/><br/>
Also you can find it as attachment in this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
