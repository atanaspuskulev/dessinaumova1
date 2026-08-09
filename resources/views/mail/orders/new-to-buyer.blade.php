<x-mail::message>
# Вашата поръчка е приета

Благодарим Ви за покупката от <a href="http://desinaumova.com">desinaumova.com</a>.<br />
Вашата поръчка <b>{{ $order->order_id }}</b> е успешно създадена и приета и ще бъде обработена в най-кратък срок.<br /><br />

<x-mail::table>
    | Артикул       | Количество    | Цена         | Валута  |
    | ------------- |:-------------:|:-------------:| --------:|
    @foreach($order->items as $item)
        | {{ $item->product->title }} | {{ $item->quantity }} | {{ $item->price }} | {{ $item->currency }} |
    @endforeach
    | Total      | {{ $totalPrice }} | {{ $order->currency }} |
</x-mail::table>
<br /><br />
@if($order->delivery_method)
Начин на доставка: <b>{{ ucfirst($order->delivery_method) }}</b><br />
@endif
@if($order->payment_method)
Начин на плащане: <b>{{ $order->payment_method === 'cod' ? __('cart.cash_on_delivery') : __('cart.pay_with_paypal') }}</b><br /><br />
@endif
Поздрави,<br />
Деси Наумова
</x-mail::message>
