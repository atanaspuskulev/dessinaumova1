<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Orders extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'amount',
        'currency',
        'payer_name',
        'payer_email',
        'payer_phone',
        'payer_country',
        'payer_country_code',
        'payer_state',
        'payer_city',
        'payer_address',
        'payer_zip',
        'additional_information',
        'confirmed_at',
        'cancelled_at',
        'resended_at'
    ];

    public static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'DESC');
        });

        static::creating(function($item) {
            $item->created_at = now()->toDateString();
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrdersItems::class, 'order_id', 'id');
    }
}
