@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Sản phẩm</a>
                        </li>
                        <li>
                            <a href="" title="">{{ $this_cat_name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">Sản phẩm</h3>
                        <div class="filter-wp fl-right">
                            <p class="desc">Có tất cả {{ $count_product_total }} sản phẩm</p>
                            <div class="form-filter">
                                <form method="POST" action="{{ route('filter_product') }}" class="ajax-filter-form"
                                    id="filter-form-1">
                                    @csrf
                                    <select name="select">
                                        <option value="0"
                                            {{ request()->input('select') == 0 ? 'selected=selected' : '' }}>Sắp xếp
                                        </option>
                                        <option value="1"
                                            {{ request()->input('select') == 1 ? 'selected=selected' : '' }}>Từ A-Z</option>
                                        <option
                                            value="2"{{ request()->input('select') == 2 ? 'selected=selected' : '' }}>
                                            Từ Z-A</option>
                                        <option
                                            value="3"{{ request()->input('select') == 3 ? 'selected=selected' : '' }}>
                                            Giá cao xuống thấp</option>
                                        <option
                                            value="4"{{ request()->input('select') == 4 ? 'selected=selected' : '' }}>
                                            Giá thấp lên cao</option>
                                    </select>
                                    <button type="submit">Lọc</button>
                                </form>
                            </div>
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
                                " href="{{ route('cart.list') }}" class="btn btn-primary">Xem giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail" class="ajax-container">
                        <ul class="list-item clearfix">
                            @if ($products->total() > 0)
                                @foreach ($products as $item)
                                    <li>
                                        <form action="{{ route('cart.add', $item->id) }}" method="get"
                                            class="add-to-cart-form">
                                            @csrf
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
                                                {{-- <button id="add-to-cart-buy" class="add-cart fl-left"
                                                onclick="showAddToCartModal()" data-product-id="{{ $item->id }}">Thêm
                                                giỏ hàng</button> --}}
                                                {{-- <a href="{{ route('cart.add', $item->id) }}" title="Thêm giỏ hàng"
                                                    class="add-cart fl-left" onclick="showAddToCartModal()"
                                                    id="addToCartButton">Thêm giỏ hàng</a> --}}
                                                <button id="css-button" type="submit"
                                                    class="btn btn-primary add-to-cart-btn">Thêm giỏ hàng</button>
                                                <a href="{{ route('detailProduct', $item->id) . $item->slug_product }}"
                                                    title="Mua ngay" class="buy-now fl-right">Xem chi tiết</a>
                                            </div>
                                        </form>
                                    </li>
                                @endforeach
                                </form>
                            @else
                                <td class="text text-danger bg-white">
                                    <p style="color: red;font-weight:bold;font-size:20px"> Không tìm thấy sản phẩm nào!</p>
                                </td>
                                <img style=" display: block;
                                margin: 0 auto;"
                                    src="{{ asset('client/images/tim-kiem-hinh-anh-tren-tao-bao.jpg') }}" alt="">
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                {{ $products->links() }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    @include('client.components.sidebar-productCat')
                </div>
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        <form method="POST" action="{{ route('price_product') }}">
                            @csrf
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Giá</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="r-price" value="1" id="1"></td>
                                        <td><label for="1">Dưới 500.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" value="2"id="2"></td>
                                        <td><label for="2">500.000đ - 1.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" value="3"id="3"></td>
                                        <td><label for="3">1.000.000đ - 5.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price"value="4"id="4"></td>
                                        <td><label for="4">5.000.000đ - 10.000.000đ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price" value="5"id="5"></td>
                                        <td><label for="5">Trên 10.000.000đ</label></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit">Lọc Ngay</button>

                        </form>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="?page=detail_product" title="" class="thumb">
                            <img src="public/client/images/banner.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-item.active .page-link {
            border-color: #043d7a !important;
            background-color: #043d7a !important;
        }

        
    </style>

@endsection
