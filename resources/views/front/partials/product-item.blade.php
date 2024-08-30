<div class="{{ isset($columnClass) ? $columnClass : 'col-md-3' }} col-sm-12 mb-5">
    <div class="card mb-4 rounded-3 card-box-shadow">
        <img
            src="{{ displayImage($productItem->id, $productItem->thumbnail?->path, true) }}"
            class="card-img-top" alt="{{ $productItem->title }}"
        >
        <div class="card-body">
            <h3 class="card-title">{{ $productItem->title }}</h3>
            <p class="card-text">{!! $productItem->short_description !!}</p>
            <h3>Price: {{ $productItem->price }}&euro;</h3>
            <br>
            <p>
                <span class="badge rounded-pill bg-secondary">
                        <a
                            href="{{ route('front.to_category', ['category' => $productItem->category->slug]) }}"
                            class="common-link"
                        >
                            &#x27A1; In {{ $productItem->category->title }}
                        </a>
                </span>
            </p>
            <a href="{{ route('front.product_view', ['category_slug' => $productItem->category->slug, 'product_slug' => $productItem->slug]) }}"
               class="product-button mb-3 position-absolute bottom-0 end-0 me-3">View More</a>
        </div>
    </div>
</div>
