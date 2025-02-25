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
Може да свалите вашата фактура <a target="_new" href="{{ $invoice['url'] }}">от тук</a>.<br/><br/>
Също, може да я намерите, като прикачен файл в този e-mail.<br /><br />
Поздрави,<br />
Деси Наумова
</x-mail::message>
