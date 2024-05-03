@if($products->count())
    <table class="table text-start">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr id="prow-{{ $product->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    <img src="{{ displayImage($product->id, $product->thumbnail?->path, true) }}"
                         width="50"/>
                    <a target="_new"
                       href="{{ route('front.product_view', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}"
                       class="text-black-50">
                        {!! $product->title !!}
                    </a>
                </td>
                <td>{!! $product->category->title !!}</td>
                <td>{!! number_format($product->price, 2, '.', '') !!}&euro;</td>
                <td>
                    <a href="javascript:void(0);"
                       onclick="confirmRemove({{ $product->id }});">Remove</a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="text-end total-price">Tax 20%: {{ number_format($taxAmount, 2, '.', '') }}&euro;</td>
        </tr>
        <tr>
            <td colspan="5" class="text-end total-price">Total: {{ number_format($totalPrice, 2, '.', '') }}&euro;</td>
        </tr>
        <tr id="btn-checkout-container">
            <td colspan="5" class="text-end">
                <a href="{{ route('front.delivery_form', compact('cart_reference_key')) }}" class="btn btn-success">Proceed
                    To Checkout</a>
            </td>
        </tr>
        </tbody>
    </table>
@else
    <p>
        Your cart is currently empty. You do not have added products yet.
    </p>
    <p>
        You can browse my beautiful artwork from
        @foreach($categories as $category)
            <a href="{{ route('front.to_category', ['category' => $category->slug]) }}">{!! $category->title !!}</a>
            @if($loop->remaining > 1)
                ,
            @elseif($loop->remaining === 1)
                or
            @endif
        @endforeach
    </p>
@endif
