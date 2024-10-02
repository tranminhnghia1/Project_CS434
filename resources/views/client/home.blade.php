@extends('layouts.client')

@section('content')
    <div class="main-content fl-right">
        <div class="section" id="slider-wp">
            <div class="section-detail">
                @foreach ($sliders as $slider)
                    <div class="item">
                        <img style="height: 384.13px;" src="{{ asset($slider->slider_thumb) }}" alt="">
                    </div>
                @endforeach


            </div>
        </div>
        <div class="section" id="support-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('client/images/icon-1.png') }}">
                        </div>
                        <h3 class="title">Miễn phí vận chuyển</h3>
                        <p class="desc">Tới tận tay khách hàng</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('client/images/icon-2.png') }}">
                        </div>
                        <h3 class="title">Tư vấn 24/7</h3>
                        <p class="desc">1900.9999</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('client/images/icon-3.png') }}">
                        </div>
                        <h3 class="title">Tiết kiệm hơn</h3>
                        <p class="desc">Với nhiều ưu đãi cực lớn</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('client/images/icon-4.png') }}">
                        </div>
                        <h3 class="title">Thanh toán nhanh</h3>
                        <p class="desc">Hỗ trợ nhiều hình thức</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{ asset('client/images/icon-5.png') }}">
                        </div>
                        <h3 class="title">Đặt hàng online</h3>
                        <p class="desc">Thao tác đơn giản</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" style="margin-top: 144px;"
            aria-labelledby="addToCartModalLabel" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addToCartModalLabel">Thông báo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 21px;">
                        Thêm sản phẩm vào giỏ hàng thành công!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tiếp tục mua
                            hàng</button>
                        <a style=" display: inline-block;color: #fff;width: 108px;
                                    height: 28px;
                                    text-align: center;
                                "
                            href="{{ route('cart.list') }}" class="btn btn-primary">Xem giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section" id="feature-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm nổi bật</h3>
            </div>
            <div class="section-detail">

                <ul class="list-item">
                    @foreach ($featured_product as $featured)
                        <li>
                            <form action="{{ route('cart.add', $featured->id) }}" method="get" class="add-to-cart-form">
                                <a href="{{ route('detailProduct', $featured->id) . $featured->slug_product }}"
                                    title="" class="thumb">
                                    <img style="height: 157.83px;" src="{{ asset($featured->product_thumb) }}">
                                </a>
                                <a style="height: 34px;"
                                    href="{{ route('detailProduct', $featured->id) . $featured->slug_product }}"
                                    title="" class="product-name">{{ $featured->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($featured->price_product, 0, ',', '.') }}đ</span>
                                    <span
                                        class="old">{{ number_format($featured->price_product * 1.3, 0, ',', '.') }}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <button id="css-button" type="submit" class="btn btn-primary add-to-cart-btn">Thêm giỏ
                                        hàng</button>
                                    <a href="{{ route('detailProduct', $featured->id) . $featured->slug_product }}"
                                        title="" class="buy-now fl-right">Xem chi tiết</a>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>


            </div>
        </div>
        <div class="section" id="list-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm đang giảm giá</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($discount_product as $discount)
                        <li>
                            <form action="{{ route('cart.add', $discount->id) }}" method="get" class="add-to-cart-form">
                                <div class="discount" style="position: relative">
                                    <img style="position: absolute;width:39px;right: -5px;
                                    top: -6px;"
                                        src="public/client/images/sale-tag.png" alt="">
                                </div>
                                <a href="{{ route('detailProduct', $discount->id) . $discount->slug_product }}"
                                    title="" class="thumb">
                                    <img style="height: 157.83px;" src="{{ asset($discount->product_thumb) }}">
                                </a>
                                <a style="height: 34px;"
                                    href="{{ route('detailProduct', $discount->id) . $discount->slug_product }}"
                                    title="" class="product-name">{{ $discount->name }}</a>
                                <div class="price">
                                    <span
                                        class="new">{{ number_format($discount->price_product, 0, ',', '.') }}đ</span>
                                    <span
                                        class="old">{{ number_format($discount->price_product * 1.3, 0, ',', '.') }}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <button id="css-button" type="submit" class="btn btn-primary add-to-cart-btn">Thêm
                                        giỏ
                                        hàng</button>
                                    <a href="{{ route('detailProduct', $discount->id) . $discount->slug_product }}"
                                        title="Xem chi tiết" class="buy-now fl-right">Xem chi tiết</a>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="list-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm mới nhất</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($latest_product as $latest)
                        <li>
                            <form action="{{ route('cart.add', $latest->id) }}" method="get" class="add-to-cart-form">
                                @csrf
                                <a href="{{ route('detailProduct', $latest->id) . $latest->slug_product }}"
                                    title="" class="thumb">
                                    <img style="height: 157.83px;" src="{{ asset($latest->product_thumb) }}">
                                </a>
                                <a style="height: 34px;"
                                    href="{{ route('detailProduct', $latest->id) . $latest->slug_product }}"
                                    title="" class="product-name">{{ $latest->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($latest->price_product, 0, ',', '.') }}đ</span>
                                    <span
                                        class="old">{{ number_format($latest->price_product * 1.3, 0, ',', '.') }}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <button id="css-button" type="submit" class="btn btn-primary add-to-cart-btn">Thêm
                                        giỏ
                                        hàng</button>
                                    <a href="{{ route('detailProduct', $latest->id) . $latest->slug_product }}"
                                        title="Xem chi tiết" class="buy-now fl-right">Xem chi tiết</a>
                                </div>
                            </form>
                        </li>
                    @endforeach


                </ul>
            </div>
        </div>
    </div>
    <div class="sidebar fl-left">
        <div class="section" id="category-product-wp">
            @include('client.components.sidebar-productCat')
        </div>
        <div class="section" id="selling-wp">
            @include('client.components.sidebar-productTop')
        </div>
        <div class="section" id="banner-wp">
            <div class="section-detail">
                @foreach ($banners as $item)
                    <a href="" title="" class="thumb">
                        <img style="    margin-bottom: 18px;" src="{{ asset($item->product_thumb) }}" alt="">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        ul>li {
            position: relative;
        }

        ul>li>.discount {
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            z-index: 100;
        }

        ul>li>.discount img {
            width: 100%;
            display: block;
        }

        #list-product-wp .section-head {
            border-bottom: 2px solid #333;
            height: 39px;
        }

        #list-product-wp .section-title {
            font-size: 21px;
            text-transform: uppercase;
            line-height: normal;
            margin: 40px 0px 20px 0px;
            background: #1e272e;
            color: #44bd32;
            width: 297px;
            padding: 5px 15px
        }

        #feature-product-wp .section-head {
            border-bottom: 2px solid #333;
            height: 39px;
        }

        #feature-product-wp .section-title {
            font-size: 21px;
            text-transform: uppercase;
            line-height: normal;
            margin: 40px 0px 20px 0px;
            background: #1e272e;
            color: #44bd32;
            width: 232px;
            padding: 5px 15px
        }
    </style>
@endsection
