@if($products->count())
    <div class="row mt-5 p-4">
        <div class="col-md-8 bg-light border">
            @foreach($products as $product)
                @php
                    $qty = 0;
                    $totalProductPrice = 0;
                @endphp

                @foreach($cart as $item)
                    @if($item['product_id'] == $product->id)
                        @php
                            $qty = $item['quantity'];
                            $totalProductPrice = $item['price'];
                        @endphp
                    @endif
                @endforeach
                <div class="row">
                    <div class="col">
                        <img
                            src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}"
                            width="150"
                        />
                    </div>
                    <div class="col pt-5">
                        <div class="fs-5 fw-bold w-100">{{ $product->title }}</div>
                        <div>Единична цена:  @price($product->price, $product->currency)</div>
                    </div>
                    <div class="col pt-3">
                        <div class="text-end w-100 mb-3">
                            <a href="{{ route('front.remove_product_from_cart', ['id' => $product->id]) }}" class="text-danger remove-product">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                        <div class="text-end w-100 d-flex justify-content-end">
                            <div class="form-group col-3 col-sm-3 col-md-3">
                                <input
                                    @if(!$product->has_qty)
                                        disabled
                                    @endif
                                    min="0"
                                    type="number"
                                    value="{{ $qty }}"
                                    class="form-control qty-input"
                                    data-product-id="{{ $product->id }}"
                                    data-url="{{ route('front.update_quantity', ['id' => $product->id]) }}"
                                />
                            </div>
                        </div>
                        <div class="text-end w-100 mt-3 fs-4 text-danger">
                            {{ $totalProductPrice }}
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr />
                    @endif
                </div>
            @endforeach
        </div>
        <div class="col-md bg-light  ms-md-3 pt-4 border">
            <p>
                Забележка: без цена за доставка
            </p>

            <p>
                Обща сума: {{ $totalPrice }}
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('front.index') }}" class="btn btn-outline-secondary rounded-0">Разгледай още</a>
                <a href="{{ route('front.delivery_form') }}" class="btn btn-danger rounded-0">Завърши поръчката</a>
            </div>
        </div>
    </div>
@else
    <div class="row mt-5 p-4 justify-content-center">
        <div class="col-md-8 bg-light border fs-4 p-5">
            {{ __('messages.empty_cart') }}
        </div>
    </div>
@endif

<script>
    $(function() {
        if($('.remove-product').length > 0) {
            $('.remove-product').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $.post($(this).attr('href'), {_token: $('meta[name="csrf-token"]').attr('content')}, function(response) {
                    $('.cart-list').empty().html(response.html);
                });
            });
        }

        if($('.qty-input').length > 0 && $('#myInput').attr('disabled') == undefined) {
            $('.qty-input').on('input', function() {
                let url = $(this).data('url');

                $.post(url, {_token: $('meta[name="csrf-token"]').attr('content'), qty: $(this).val()}, function(response) {
                    $('.cart-list').empty().html(response.html);
                });
            });
        }
    });
</script>
