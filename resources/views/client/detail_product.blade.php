@extends('layouts.client')

@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Điện thoại</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                <img style="width: 343px" id="zoom" src="{{ asset($detail_product->product_thumb) }}"
                                    data-zoom-image="{{ asset($detail_product->product_thumb) }}" />
                            </a>
                            <div id="list-thumb">
                                @foreach ($productImage as $product)
                                    <a href="" data-image="{{ asset("uploads\\$product") }}"
                                        data-zoom-image="{{ asset("uploads\\$product") }}">
                                        <img style="width: 343px" id="zoom" src="{{ asset("uploads\\$product") }}" />
                                    </a>
                                @endforeach


                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            <img src="public/images/img-pro-01.png" alt="">
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $detail_product->name }}</h3>
                            <div class="desc">
                                {!! $detail_product->content_desc !!}
                            </div>
                            <div class="num-product">
                                <span class="title">Sản phẩm: </span>
                                <span class="status">Còn hàng({{ $detail_product->number_product }})</span>
                            </div>
                            <p class="price">{{ number_format($detail_product->price_product, 2, ',', '.') }}đ</p>
                            <form action="{{ route('add_cart_detail', $detail_product->id) }}" method="GET">
                                @csrf
                                <div id="num-order-wp">
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="num" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>

                                {{-- <a href="{{ route('cart.add', $detail_product->id) }}" title="Thêm giỏ hàng"
                                    class="add-cart">Thêm giỏ hàng</a> --}}
                                <button onclick="location.href='{{ route('add_cart_detail', $detail_product->id) }}'"
                                    class="add-cart">Thêm giỏ hàng</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail product-content">
                        {!! $detail_product->content !!}
                        <div id="bg-article" style="display: block;"></div>
                        <div class="more button-see">Xem thêm</div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Đánh giá sản phẩm</h3>
                    </div>
                    <div class="section-detail">
                        @if (auth()->check())
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $detail_product->id }}">
                                <div class="form-group">

                                    <textarea name="review_text" id="review_text" rows="5" cols="100" class="form-control" required
                                        placeholder="Nhập đánh giá của bạn tại đây..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rating">Đánh giá (Chọn sao)</label>
                                    {{-- <select name="rating" id="rating" class="form-control" required>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select> --}}
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label
                                            for="star5" title="Rất tốt">5 <i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label
                                            for="star4" title="Tốt">4 <i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label
                                            for="star3" title="Bình thường">3 <i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label
                                            for="star2" title="Tệ">2 <i class="fa-solid fa-star"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label
                                            for="star1" title="Rất tệ">1 <i class="fa-solid fa-star"></i></label>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary custom-btn">Gửi đánh giá</button>
                                </div>
                            </form>
                        @else
                            <p>Bạn cần <a href="{{ route('login') }}"><strong>đăng nhập</strong></a> để gửi đánh giá.</p>
                        @endif

                        <h4 style="font-style: italic;
                        font-size: 20px;
                        color: #d9c210; margin-bottom: 15px;">Đánh giá từ khách hàng</h4>
                        <ul>
                            @foreach ($reviews as $review)
                                <li style="margin-bottom: 12px;">
                                    <strong><i class="fa-solid fa-face-smile"></i>  {{ $review->user->name }}</strong>
                                    <p style="padding-bottom: 0px">{{ $review->review_text }}</p>
                                    <p style="padding-bottom: 0px">Đánh giá: {{ $review->rating }} <i style="color: #ebeb10;" class="fa-solid fa-star"></i></p>
                                    <p>Thời gian đánh giá: {{ $review->created_at }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>


                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">

                        <ul class="list-item">
                            @foreach ($sameCategory as $item)
                                <li>
                                    <a href="{{ route('detailProduct', $item->id) . $item->slug_product }}"
                                        title="" class="thumb">
                                        <img style="height: 157.83px;" src="{{ asset($item->product_thumb) }}">
                                    </a>
                                    <a style="height: 34px;"
                                        href="{{ route('detailProduct', $item->id) . $item->slug_product }}"
                                        title="" class="product-name">{{ $item->name }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($item->price_product, 0, ',', '.') }}đ</span>
                                        <span
                                            class="old">{{ number_format($item->price_product * 1.3, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.add', $item->id) }}" title=""
                                            class="add-cart fl-left">Thêm giỏ
                                            hàng</a>
                                        <a href="{{ route('detailProduct', $item->id) . $item->slug_product }}"
                                            title="" class="buy-now fl-right">Xem chi tiết</a>
                                    </div>
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
                        <a href="" title="" class="thumb">
                            <img src="public/images/banner.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #main-thumb .zoomWrapper img {
            width: 343px !important;
            position: absolute;
            height: auto !important;
        }

        /* cuộn content */
        #post-product-wp .product-content.active {
            height: auto;
            overflow: unset;
            margin-bottom: 72px;
        }

        #post-product-wp .product-content {
            position: relative;
            height: 600px;
            overflow: hidden;
            transition: all 0.3s linear;
        }

        .button-see {
            background-color: #fff;
            border: 1px solid #ff0251;
            color: #ff0251;
            transition: 0.3s;
            border-radius: 5px;
        }

        .more {
            position: absolute;
            display: inline-block;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 250px;
            padding: 6px 0;
            text-align: center;
            color: red;
            text-transform: uppercase;
            font-weight: 400;
            cursor: pointer;
            display: inline-block;
        }

        #bg-article {
            background: linear-gradient(to bottom, rgba(255 255 255/0), rgba(255 255 255/62.5), rgba(255 255 255/1));
            bottom: 0px;
            height: 105px;
            left: 0;
            position: absolute;
            width: 100%;
        }

        /* //rating */
        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 0;
            margin-left: 25px
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            display: inline-block;
            padding: 0;
            cursor: pointer;
            font-size: 2rem;
            color: #ddd;
            transition: color 0.2s;
            margin: 20px;

        }

        .star-rating input[type="radio"]:checked~label {
            color: #f5b301;
        }

        .star-rating input[type="radio"]:checked~label~label {
            color: #ddd;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f5b301;
        }

        .text-center {
            text-align: center;
        }

        .custom-btn {
            background-color: #007bff;
            /* Màu nền */
            border: none;
            /* Không viền */
            color: white;
            /* Màu chữ */
            padding: 10px 20px;
            /* Khoảng đệm */
            text-align: center;
            /* Căn giữa chữ */
            text-decoration: none;
            /* Không gạch chân */
            display: inline-block;
            /* Hiển thị dưới dạng khối nội tuyến */
            font-size: 16px;
            /* Kích thước chữ */
            margin: 10px 2px;
            /* Khoảng cách */
            cursor: pointer;
            /* Con trỏ chuột */
            border-radius: 4px;
            /* Bo góc */
        }

        .custom-btn:hover {
            background-color: #0056b3;
            /* Màu nền khi hover */
            color: white;
            /* Màu chữ khi hover */
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {

            let product_wp = $('#post-product-wp').offset().top;
            $(".button-see").click(function() {
                //alert('ok');
                // $(this).text($(this).text() == 'Xem thêm' ? 'Thu gọn' : 'Xem thêm');
                // $(this).parent().toggleClass('active');
                // if ($(this).text() == 'Xem thêm') {
                //     $('html,body').animate({
                //         scrollTop: product_wp
                //     }, 500);
                // }
            })
        })
    </script>
@endsection
