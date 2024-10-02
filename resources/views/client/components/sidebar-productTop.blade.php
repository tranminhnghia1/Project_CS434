<div class="section-head">
    <h3 class="section-title">Sản phẩm bán chạy</h3>
</div>
<div class="section-detail">
    <ul class="list-item">
        @foreach ($top_product as $product)
            <li class="clearfix">
                <a href="{{ route('detailProduct', $product->id).$product->slug_product  }}" title="" class="thumb fl-left">
                    <img src="{{ asset($product->product_thumb) }}" alt="">
                </a>
                <div class="info fl-right">
                    <a href="{{ route('detailProduct', $product->id).$product->slug_product  }}" title="" class="product-name">{{ $product->name }}</a>
                    <div class="price">
                        <span class="new">{{ number_format($product->price_product,0,",",".") }}đ</span>
                        <span class="old">{{ number_format($product->price_product * 1.3,0,",",".") }}đ</span>
                    </div>
                    <a href="{{ route('detailProduct', $product->id).$product->slug_product }}" title="" class="buy-now">Xem chi tiết</a>
                </div>
            </li>
        @endforeach

    </ul>
</div>
