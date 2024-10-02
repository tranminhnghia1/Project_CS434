@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="list-product-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="Trang-chu.html" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="Thong-tin-don-hang.html" title="">Thông tin đơn hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="wrap clearfix wp-inner">
            <div class="w-75 m-3 mb-4 mr-auto ml-auto d-block text-center">
                <span class="bold text-danger font-weight-bold h4 mb-2 d-block"><i
                        class="fa-solid fa-circle-check mr-2"></i> ✔ ĐẶT HÀNG THÀNH CÔNG</span>
                <p class="mb-0">Cảm ơn <span class="font-weight-bold"
                        style="color: black;font-size: 17px;font-weight: bold;">{{ $data['fullname'] }}</span> đã cho chúng tôi
                    cơ hội được cung ứng những sản phẩm cần thiết với bạn.</p>
                <p>Nhân viên của chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng, thời gian giao hàng chậm nhất là 72h.
                </p>
            </div>
        </div>
        <div class="wrap clearfix">
            <div id="content" class="detail-exhibition wp-inner">
                <form action=""method="POST">
                    @csrf
                    <div class="section" id="info">
                        <div class="order title h5 font-weight-bold text-danger">Mã đơn hàng: <span
                                class="detail">{{ $data['order_code'] }}</span></div>
                    </div>
                    <h5 class="order-info text-danger mb-1 mt-3">Thông tin khách hàng</h5>
                    <div class="section ">
                        <div class=" table-info table-responsive table-danger">

                            <table class="table info-exhibition">
                                <thead>
                                    <tr>
                                        <td>Họ và tên</td>
                                        <td>Số điện thoại</td>
                                        <td>Email</td>
                                        <td>Địa chỉ</td>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="font-weight-bold">{{ $data['fullname'] }}</td>
                                        <td>{{ $data['phone_number'] }}</td>
                                        <td>{{ $data['email'] }}</td>
                                        <td>{{ $data['address']}} - {{$data['province'] }} - {{$data['district'] }} - {{ $data['ward'] }}</td>

                                    </tr>

                                </tbody>
                            </table>


                        </div>
                        <h5 class="order-info text-danger mb-1 mt-3">Thông tin đơn hàng</h5>
                        <div class="table-responsive table-danger">

                            <table class="table info-exhibition">
                                <thead class="font-weight-bold">
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
                                    @foreach ($data['order'] as $row)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <td class="thead-text">{{ $t }}</td>
                                            <td class="thead-text">
                                                <div class="thumb">
                                                    <img style="width:75px; height:auto" src="{{ asset($row->options->thumnail) }}" alt="">
                                                </div>
                                            </td>
                                            <td class="thead-text">{{ $row->name }}</td>
                                            <td class="thead-text">{{ number_format($row->price, 0, ',', '.') }}đ</td>
                                            <td class="thead-text">{{ $row->qty }}</td>
                                            <td class="thead-text">{{ number_format($row->total, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="font-weight-bold">
                                    <tr>
                                        <td colspan="5" class="thead-text text-center" style="font-weight: bold;">Tổng
                                            tiền:
                                        </td>
                                        <td class="thead-text">{{ $data['total'] }}đ</td>
                                    </tr>
                                </tfoot>
                            </table>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .text-center .bold {
            color: red;
            font-weight: bold;
            font-size: 25px;
        }

        .order {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .order-info {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .table-info {
            margin-bottom: 15px;

        }

        .text-center {
            text-align: center;
        }
    </style>
@endsection
