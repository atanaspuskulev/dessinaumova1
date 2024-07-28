<div class="row">
    @forelse($items as $item)
        <div class="col-md-4">
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
        </div>
    @empty
        <div class="col-sm-12 col-lg-12 col-md-12">
            <h3>No items available for this order!</h3>
        </div>
    @endforelse
</div>

