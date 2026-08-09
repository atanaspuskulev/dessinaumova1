<?php

declare(strict_types=1);

namespace App\Http\Enums;

enum DeliveryMethodEnum: string
{
    case ECONT = 'econt';
    case SPEEDY = 'speedy';
}
