@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="cart-page">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (Cart::count() > 0)
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Mã sản phẩm</td>
                                        <td>Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td>Giá sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td colspan="2">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach (Cart::content() as $row)
                                        @php
                                            $t++;
                                        @endphp

                                        <tr>
                                            <td>{{ $t }}</td>
                                            <td>
                                                <a href="" title="" class="thumb">
                                                    <img src="{{ asset($row->options->thumnail) }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="" title=""
                                                    class="name-product">{{ $row->name }}</a>
                                            </td>
                                            <td>{{ number_format($row->price, 0, ',', '.') }}đ</td>
                                            <td>

                                                <input class="num_order" data-id="{{ $row->rowId }}"
                                                    name="qty[{{ $row->rowId }}]"
                                                    data-url="{{ route('ajax_shopping_cart') }}" type="number"
                                                    style="border: 1px solid #ccc;border-radius: 3px;text-align: center;height: 34px;width: 35px;"
                                                    data-rowid="[{{ $row->rowId }}]" value="{{ $row->qty }}"
                                                    max="10" min="1" id="num_order">
                                            </td>
                                            <td id="sub_total-{{ $row->rowId }}">
                                                {{ number_format($row->total, 0, ',', '.') }}đ </td>
                                            <td>
                                                <a href="{{ route('cart.remove', $row->rowId) }}" title=""
                                                    class="del-product"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">Tổng số lượng sản phẩm: <span
                                                style="color: red;font-weight:bold; font-size:17px">{{ Cart::count() }}</span>
                                        </td>
                                        <td colspan="6">
                                            <div class="clearfix">
                                                <p id="total-price" class="fl-right">Tổng giá:
                                                    <span>{{ Cart::total() }}đ</span>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <div class="fl-right">
                                                    {{-- <input id="update-cart" type="submit"value="Cập nhật giỏ hàng"
                                                        class="btn btn-secondary"> --}}

                                                    {{-- //<a href="" title="" id="update-cart">Cập nhật giỏ hàng</a> --}}
                                                    <a href="{{ route('checkout') }}" title=""
                                                        id="checkout-cart">Thanh
                                                        toán</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </form>
                        
                    </div>
                </div>
                <div class="section" id="action-cart-wp">
                    <div class="section-detail">

                        <a href="{{ route('homePage') }}" title="" id="buy-more">Mua tiếp</a><br />
                        <a href="{{ route('cart.destroy') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                    </div>
                </div>
            @else
                <p>Không có sản phẩn nào trong giỏ hàng.click <a href="{{ route('homePage') }}">vào đây</a> để
                    mua hàng tiếp!</p>
            @endif
        </div>
        {{-- <form action={{ url('/vnpay_payment') }} method="GET">
            @csrf
            @php
                $totalString = Cart::total();
                $totalNumber = floatval(preg_replace('/[^\d.]/', '', $totalString)); // Chuyển đổi giá trị thành số thực
                $totalFormatted = number_format($totalNumber, 0, ',', '.');
            @endphp

            {{-- <td id="sub_total-{{ $row->rowId }}">
                {{ number_format($row->total, 0, ',', '.') }}đ
            </td>

             <input type="hidden" name="totalpayment" value="{{ $totalFormatted }}đ"> 
            <input type="hidden" name="totalpayment" value="{{ Cart::total() }}"đ> 
            <button type="submit" name="redirect" class="btn btn-secondary">Thanh toán bằng VnPay</button>
        </form> --}}
    </div>

@endsection
