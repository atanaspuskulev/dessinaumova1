<div class="{{ isset($columnClass) ? $columnClass : 'col-md-3' }} col-sm-12 mb-5">
    <div class="card mb-4 rounded-3 card-box-shadow">
        <img
            src="{{ displayImage($productItem->id, $productItem->thumbnail?->path, true) }}"
            class="card-img-top" alt="{{ $productItem->title }}"
        >
        <div class="card-body">
            <p class="card-title">{{ $productItem->title }}</p>


            <a
                href="{{ route('front.product_view', [
                    'category_slug' => $productItem->category->slug,
                    'product_slug' => $productItem->slug
                ]) }}"
                class="product-button mb-3 position-absolute bottom-0 end-0 me-3"
            >
                {{ __('site.view_more') }}
            </a>
        </div>
    </div>
</div>
