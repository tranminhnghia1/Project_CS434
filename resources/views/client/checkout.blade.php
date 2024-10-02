@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="wrapper" class="wp-inner clearfix">
            @if (Cart::count() > 0)
                <form id="checkout-form" method="POST" name="form-checkout">
                    {{-- action="{{ route('thankyou') }}"  --}}
                    @csrf
                    <div class="section" id="customer-info-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin khách hàng</h1>
                        </div>
                        <div class="section-detail">

                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname">Họ tên <span style="color:red;">(*)</span></label>
                                    <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}">
                                    @error('fullname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="email">Email <span style="color:red;">(*)</span></label>
                                    <input type="email" name="email" id="email"value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="address">Địa chỉ <span style="color:red;">(*)</span></label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        id="address"placeholder="Ví dụ:48 Đường man thiện">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại <span style="color:red;">(*)</span></label>
                                    <input type="tel" name="phone_number" id="phone"
                                        value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row clearfix" style="display: flex;">
                                    <div class="form-col fl-left">
                                        <label for="province">Tỉnh / Thành phố <span style="color:red;">(*)</span></label>
                                        <select name="province" class="form-control" id="province" {{-- data-url="{{ route('getDistricts', ['province_id' => '__province_id__']) }}" --}}
                                            style="width:247.88px;height: 34px;border: 1px solid #cccccc;">
                                            <option value="" disabled selected>Chọn tỉnh / Thành phố</option>
                                            @foreach ($provinces as $provin)
                                                <option data-name="{{ $provin->name }} "
                                                    value="{{ $provin->province_id }}">{{ $provin->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="province_name" id="province_name">
                                        @error('province')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-col fl-right">
                                        <label style="margin-left: 33px;">Chọn Quận <span
                                                style="color:red;">(*)</span></label>
                                        <select name="district" id="district"
                                            class="form-control"placeholder="Chọn Quận Huyện" {{-- data-url="{{ route('getWards', ['district_id' => '__district_id__']) }}" --}}
                                            style="margin-left: 33px; width: 277.88px;height: 34px; border: 1px solid #cccccc;">
                                            <option selected value="">Chọn quận / Huyện</option>
                                            {{-- @foreach ($districts as $district)
                                                <option value="{{ $district->name }}">{{ $district->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <input type="hidden" name="district_name" id="district_name">
                                        @error('district')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-col">
                                    <label>Chọn Xã Phường <span style="color:red;">(*)</span></label>
                                    <select name="ward" id="ward"
                                        class="form-control"style="height: 34px;border: 1px solid #cccccc; width: 558px;">
                                        <option selected value="">Chọn phường / Xã</option>
                                        {{-- @foreach ($wards as $ward)
                                            <option value="{{ $ward->name }}">{{ $ward->name }}</option>
                                        @endforeach --}}

                                    </select>
                                    <input type="hidden" name="ward_name" id="ward_name">
                                    @error('ward')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="notes">Ghi chú(không bắt buộc!)</label>
                                    <textarea style="width: 558px; height: 114px;" name="note"placeholder="Ghi chú đơn hàng"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="section" id="order-review-wp">
                        <div class="section-head">
                            <h1 class="section-title">Thông tin đơn hàng</h1>
                        </div>
                        <div class="section-detail">
                            <table class="shop-table">
                                <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td style="padding-right: 56px;">Hình ảnh</td>
                                        <td>Tổng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $row)
                                        <tr class="cart-item">
                                            <td class="product-name">{{ $row->name }}<strong style="color: red"
                                                    class="product-quantity">x {{ $row->qty }}</strong>
                                            </td>
                                            <td>
                                                <a href="" title="" class="thumb">
                                                    <img style="width: 78px;" src="{{ asset($row->options->thumnail) }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td class="product-total"> {{ number_format($row->total, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <td>Tổng đơn hàng:</td>
                                        <td><strong class="total-price">{{ Cart::total() }}đ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div id="payment-checkout-wp">
                                <ul id="payment_methods">
                                    <li>
                                        <input type="radio" id="payment-home" name="payment" value="home"checked>
                                        <label for="payment-home">Thanh toán tại nhà</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="payment-vnpay" name="payment" value="vnpay">
                                        <label for="payment-vnpay">Thanh toán bằng VNPAY</label>
                                        
                                    </li>
                                    {{-- @php
                                        $totalString = Cart::total();
                                        $totalNumber = floatval(preg_replace('/[^\d.]/', '', $totalString)); // Chuyển đổi giá trị thành số thực
                                        $totalFormatted = number_format($totalNumber, 0, ',', '.');
                                    @endphp

                                    <td id="sub_total-{{ $row->rowId }}">
                                        {{ number_format($row->total, 0, ',', '.') }}đ
                                    </td>

                                    <input type="hidden" name="totalpayment" value="{{ $totalFormatted }}đ">
                                    <input type="hidden" name="totalpayment" value="{{ Cart::total() }}"đ>
                                    <button type="submit" name="redirect" class="btn btn-secondary">Thanh toán bằng
                                        VnPay</button> --}}
                                </ul>
                            </div>
                            <div class="place-order-wp clearfix">
                                {{-- <a href="{{ route('thankyou') }}" title="" id="checkout-cart">Thanh
                                toán</a> --}}
                                <input type="submit" id="order-now" value="Đặt hàng">
                            </div>
                        </div>
                    </div>

                </form>
            @else
                <p>Không có sản phẩn nào trong này.vui lòng click <a href="{{ route('homePage') }}">vào đây</a> để
                    mua hàng tiếp!</p>
            @endif
        </div>
    </div>
    <style>
        .text-danger {
            color: red;
        }
    </style>
    <script src="{{ asset('client/js/jquery-3.4.1.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#province').on('change', function() {
                let province_id = $(this).val();
                // alert(province_id);
                //console.log(province_id);
                $.ajax({
                    type: 'GET',
                    url: 'get-districts/' + province_id,

                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        // clear the district select options xóa trùng lặp huyện của các tỉnh
                        $('#district').html('');
                        // remove duplicates from the response
                        var unique_districts = [];

                        $.each(response, function(index, element) {
                            if ($.inArray(element['district_id'], unique_districts) ===
                                -1) {
                                unique_districts.push(element['district_id']);
                                $('#district').append(
                                    `<option data-name="${element['name']} " value="${element['district_id']}">${element['name']}</option>`
                                );
                            }
                        });
                        // reset the district select value to default
                        $('#district').val('');
                    }
                });
            });
            //quận, xã
            $('#district').on('change', function() {
                let district_id = $(this).val();
                // alert(province_id);

                $.ajax({
                    type: 'GET',
                    url: 'get-wards/' + district_id,

                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);



                        // clear the district select options xóa trùng lặp huyện của các tỉnh
                        $('#ward').html('');
                        // remove duplicates from the response
                        var unique_wards = [];

                        $.each(response, function(index, element) {
                            if ($.inArray(element['ward_id'], unique_wards) ===
                                -1) {
                                unique_wards.push(element['ward_id']);
                                $('#ward').append(
                                    `<option data-name="${element['name']} " value="${element['ward_id']}">${element['name']}</option>`
                                );
                            }
                        });

                        // response.forEach(element => {
                        //     $('#ward').append(
                        //         `<option data-name="${element['name']} " value="${element['ward_id']}">${element['name']}</option>`
                        //     );
                        // });
                        // reset the district select value to default
                        $('#ward').val('');
                    }
                });
            });
        });

        ///thêm tên tỉnh quận xã vào mysql(thêm 1 input hidden) thêm thuộc tính data-name vào option
        // Sau đó, để lấy giá trị tên tỉnh từ select box, 
        // ta có thể sử dụng JavaScript để lấy giá trị data-name tương ứng 
        // với giá trị được chọn trong select box và gán giá trị đó vào một input field ẩn.
        $('#province').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var provinceName = selectedOption.data('name');
            $('#province_name').val(provinceName);
        });
        $('#district').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var districtName = selectedOption.data('name');
            $('#district_name').val(districtName);
        });
        $('#ward').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var wardName = selectedOption.data('name');
            $('#ward_name').val(wardName);
        });

        //payment
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkout-form').submit(function(event) {
                event.preventDefault();
                let paymentMethod = $('#payment_methods input[name="payment"]:checked').val();
                if (paymentMethod === 'home') {
                    $(this).attr('action', '{{ route('thankyou') }}');
                    $(this).attr('method', 'POST');
                } else if (paymentMethod === 'vnpay') {
                    $(this).attr('action', '{{ route('vnpay_payment') }}');
                    $(this).attr('method', 'GET');
                }
                this.submit();
            });
        });
    </script>
@endsection

{{-- @section('address')
    
    <script src="{{ asset('client/js/address.js') }}" type="text/javascript"></script>
@endsection --}}
