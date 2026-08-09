<x-mail::message>
# Поръчка: {{ $order->order_id }}

Здравейте, {{ $order->payer_name }},

Вашата поръчка в {{ config('app.name') }} беше успешно завършена. По-долу ще намерите подробна информация за нея.

<b>Ще намерите и Вашата фактура, приложена към това съобщение.</b>

<x-mail::table>
    | Артикул       | Цена         | Валута  |
    | ------------- |:-------------:| --------:|
    @foreach($order->items as $item)
        | {{ $item->product->title }} | {{ $item->product->price }} | {{ $order->currency }} |
    @endforeach
    | Total      | {{ $totalPrice }} | {{ $order->currency }} |
</x-mail::table>
<br /><br />
@if($order->delivery_method)
Начин на доставка: <b>{{ ucfirst($order->delivery_method) }}</b><br />
@endif
@if($order->payment_method)
Начин на плащане: <b>{{ $order->payment_method === 'cod' ? __('cart.cash_on_delivery') : __('cart.pay_with_paypal') }}</b><br />
@endif
<br />
Може да свалите вашата фактура <a target="_new" href="{{ $invoice['url'] }}">от тук</a>.<br/><br/>
Също, може да я намерите, като прикачен файл в този e-mail.

Поздрави,<br>
{{ config('app.name') }}
</x-mail::message>
