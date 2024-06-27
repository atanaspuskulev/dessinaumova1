<?php

namespace App\Helpers;

class Order
{
    public static function generateInvoiceNumber(mixed $orderId): string
    {
        $orderId = (string) $orderId;
        $length = strlen($orderId);

        if ($length < 6) {
            return str_pad($orderId, 6, '0', STR_PAD_LEFT);
        }

        if ($length > 6) {
            return '0'.$orderId;
        }

        if($length === 6) {
            return $orderId;
        }
    }
}
