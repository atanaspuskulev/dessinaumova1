<x-mail::message>
# Your new order has been created

Thank you for purchasing from my website. Your order <b>{{ $order->order_id }}</b> has been created.<br /><br />
After you complete your payment, another confirmation email will be sent with full detailed information.

Regards,<br />
{{ config('app.name') }}
</x-mail::message>
