<?php

declare(strict_types=1);

namespace App\Http\Enums;

enum OrderEnum: string
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case CANCELED = 'Canceled';
}
