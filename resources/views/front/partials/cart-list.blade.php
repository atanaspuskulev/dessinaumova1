@if($products->count())
    <table class="table text-start">
        <thead>
        <tr>
            <th scope="col">{{ __('cart.num') }}</th>
            <th scope="col">{{ __('cart.product') }}</th>
            <th scope="col">{{ __('cart.category') }}</th>
            <th scope="col">{{ __('site.price') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr id="prow-{{ $product->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img
                        src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}"
                        width="50"
                    />
                    <a
                        target="_new"
                        href="{{ route('front.product_view', [
                            'category_slug' => $product->category->slug,
                            'product_slug' => $product->slug
                        ]) }}"
                        class="text-black-50"
                    >
                        {!! $product->title !!}
                    </a>
                </td>
                <td>{!! $product->category->title !!}</td>
                <td>{!! number_format($product->price, 2, '.', '') !!}&euro;</td>
                <td>
                    <a href="javascript:void(0);"
                       onclick="confirmRemove({{ $product->id }});">{{ __('cart.remove') }}</a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="text-end total-price">
                {{ __('site.shipping_cost_label') }}:
                @shipping_cost($product->shipping_cost)
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-end total-price">
                {{ __('cart.tax_lbl') }} {{ config('payment.default_tax_percent') }}%:
                @price($taxAmount)
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-end total-price">
                {{ __('cart.total') }}:
                @price($totalPrice)
            </td>
        </tr>
        <tr id="btn-checkout-container">
            <td colspan="5" class="text-end">
                <a
                    href="{{ route('front.delivery_form', compact('cart_reference_key')) }}"
                    class="btn btn-success"
                >
                    {{ __('cart.to_checkout') }}
                </a>
            </td>
        </tr>
        </tbody>
    </table>
@else
    <p>{{ __('messages.empty_cart') }}</p>
    <p>
        {{ __('messages.browse_artwork_msg') }}
        @foreach($categories as $category)
            <a
                href="{{ route('front.to_category', [
                    'category' => $category->slug
                ]) }}"
            >
                {!! $category->title !!}
            </a>
            @if($loop->remaining > 1), @elseif($loop->remaining === 1) or @endif
        @endforeach
    </p>
@endif
