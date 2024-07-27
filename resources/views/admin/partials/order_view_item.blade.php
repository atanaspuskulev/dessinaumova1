@forelse($items as $item)
    <div class="row">
        <div class="col"><b>Item</b></div>
    </div>
    <div class="row mb-3">
        <div class="col order_id_col">{{ $item->title }}</div>
    </div>
    <hr />
    <div class="row">
        <div class="col"><b>Price</b></div>
    </div>
    <div class="row mb-3">
        <div class="col order_id_col">{{ $item->price }} {{ $item->currency ?? config('paypal.currency') }}</div>
    </div>
    <hr />
@empty
    <h3>No items available for this order!</h3>
@endforelse
