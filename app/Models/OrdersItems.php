<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersItems extends Model
{
    protected $fillable = ['order_id', 'product_id', 'price', 'quantity', 'currency'];

    public $timestamps = false;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
