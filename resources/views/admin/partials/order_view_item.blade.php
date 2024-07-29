<div class="row">
    @forelse($items as $item)
        <div class="col-md-5 border rounded ml-3 mb-2">
            <div class="row">
                <div class="col"><b>Item</b></div>
            </div>
            <div class="row mb-3">
                <div class="col order_id_col"><a href="">{{ $item->title }}</a></div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <img src="{{ displayImage($item->id, $item->thumbnail?->path, true) }}" class="card-img-top" alt="Product 1">
                </div>
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

