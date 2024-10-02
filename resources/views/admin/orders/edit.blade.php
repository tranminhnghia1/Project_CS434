@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('statuss'))
            <div class="alert alert-success">
                {{ session('statuss') }}
            </div>
        @endif
        <div id="main-content-wp" class="list-product-page">
            <div style="background-color: #fff;" class="wrap clearfix">

                <div id="content" class="detail-exhibition fl-right">
                    <div class="section" id="info">
                        <div class="section-head">
                            <h3 class="section-title">Thông tin đơn hàng</h3>
                        </div>
                        <ul class="list-item">
                            <li style="list-style-type:none;">
                                <h3 class="title">Mã đơn hàng</h3>
                                <span class="detail">{{ $list_order->order_code }}</span>
                            </li>
                            <li>
                                <h3 class="title">Địa chỉ nhận hàng</h3>
                                <span class="detail">{{ $list_order->address }} - {{ $list_order->province }} -
                                    {{ $list_order->district }} - {{ $list_order->ward }}</span>
                            </li>
                            <li>
                                <h3 class="title">Thông tin vận chuyển</h3>
                                @if ($list_order->payment == 'home')
                                    <span class="detail">Thanh toán tại nhà</span>
                                @elseif($list_order->payment == 'direct')
                                    <span class="detail">Thanh toán tại cửa hàng</span>
                                @endif
                            </li>
                            <form action="{{ url('admin/orders/edit', $list_order->id) }}" method="">
                                @csrf
                                <div class="form-action form-inline py-3">
                                    <select class="form-control mr-1" id="" name="act">
                                        <option>Cập nhật trạng thái đơn hàng</option>
                                        @foreach ($list_act as $k => $act)
                                            {{-- $k là key và act là tên của hành động --}}
                                            <option value="{{ $k }}">{{ $act }}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                </div>
                            </form>
                        </ul>
                    </div>
                    <div class="section">
                        <div class="section-head">
                            <h3 class="section-title">Sản phẩm đơn hàng</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table info-exhibition">
                                <thead>
                                    <tr>
                                        <td class="thead-text">STT</td>
                                        <td class="thead-text">Ảnh sản phẩm</td>
                                        <td class="thead-text">Tên sản phẩm</td>
                                        <td class="thead-text">Đơn giá</td>
                                        <td class="thead-text">Số lượng</td>
                                        <td class="thead-text">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($detail_products as $product)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <td class="thead-text">{{ $t }}</td>
                                            <td class="thead-text">
                                                <div class="thumb">
                                                    <img src="{{ asset($product['options']['thumnail']) }} "
                                                        alt="">
                                                </div>
                                            </td>
                                            <td class="thead-text">{{ $product['name'] }}</td>
                                            <td class="thead-text">{{ number_format($product['price'], 0, ',', '.') }}đ
                                            </td>
                                            <td class="thead-text">{{ $product['qty'] }}</td>
                                            <td class="thead-text">{{ number_format($product['subtotal'], 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="section">
                        <h3 class="section-title">Giá trị đơn hàng</h3>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                <li>
                                    <span class="total-fee">Tổng số lượng</span>
                                    <span class="total">Tổng đơn hàng</span>
                                </li>
                                <li>
                                    <span class="total-fee">{{ $list_order->num_order }} sản phẩm</span>
                                    <span class="total">{{ $list_order->total_price }} VNĐ</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
