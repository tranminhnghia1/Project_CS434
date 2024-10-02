<div class="">
    <div class="aHl"></div>
    <div id=":ua" tabindex="-1"></div>
    <div id=":tz" class="ii gt" jslog="20277; u014N:xr6bB; 4:W251bGwsbnVsbCxbXV0.">
        <div id=":ty" class="a3s aiL ">
            <div
                style="margin:0;padding:0;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                <div class="adM">
                </div>
                <div style="width:1170px;height:auto;padding:15px;margin:0px auto;background-color:#f2f2f2">
                    <div class="adM">
                    </div>
                    <div>
                        <div class="adM">
                        </div>
                        <div>
                            <div class="adM">
                            </div>
                            <h1 style="font-size:14px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Chào
                                {{ $fullname }}. Đơn hàng của bạn đã đặt thành công!</h1>
                            <p
                                style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">
                                Chúng tôi đang chuẩn bị hàng để bàn giao cho đơn vị vận chuyển</p>
                            <h3
                                style="font-size:13px;font-weight:bold;color:#004cffd9;text-transform:uppercase;margin:12px 0 0 0;border-bottom:1px solid #ddd">
                                MÃ ĐƠN HÀNG: <b>{{ $order_code }}</b> <br>
                                
                            </h3>
                        </div>
                        <div>


                            <table
                                style="margin:20px 0px;width:100%;border-collapse:collapse;border-spacing:2px;background:#f5f5f5;display:table;box-sizing:border-box;border:0;border-color:grey">
                                <thead style="background:red">
                                    <tr>
                                        <th
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Tên khách hàng</strong>
                                        </th>
                                        <th
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Email</strong>
                                        </th>
                                        <th
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>SĐT</strong>
                                        </th>
                                        <th
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Địa chỉ giao hàng</strong>
                                        </th>
                                        <th
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Trạng thái đơn hàng</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        style="border-bottom:1px solid #e1dcdc;font-size:14px;margin-top:10px;line-height:30px">
                                        <td style="padding:3px 9px"><strong>{{ $fullname }}</strong></td>
                                        <td style="padding:3px 9px"><strong><a href="mailto:nghia101022@gmail.com"
                                                    target="_blank">{{ $email }}</a></strong></td>
                                        <td style="padding:3px 9px"><strong>{{ $phone_number }}</strong></td>
                                        <td style="padding:3px 9px"><strong> {{ $province }} - {{ $district }} -
                                                {{ $ward }}</strong></td>
                                        <td style="padding:3px 9px"><strong><span style="color:#00890099">Chờ xét
                                                    duyệt</span></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table
                                style="margin:20px 0px;width:100%;border-collapse:collapse;border-spacing:2px;background:#f5f5f5;display:table;box-sizing:border-box;border:0;border-color:grey">
                                <thead style="background:rgb(48, 234, 6)">
                                    <tr>
                                        <td
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Ảnh</strong></td>
                                        <td
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Tên sản phẩm</strong>
                                        </td>
                                        <td
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Giá</strong>
                                        </td>
                                        <td
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Số lượng</strong>
                                        </td>
                                        <td
                                            style="text-align:left;background-color:rgb(48, 234, 6);padding:6px 9px;color:#fff;text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Thành tiền</strong>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($order as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr style="border-bottom:1px solid #e1dcdc">
                                            <td style="padding: 5px;">Ảnh đang gặp lỗi!</td>
                                            <td style="padding:3px 9px;vertical-align:middle"><strong>{{$item->name}}</strong></td>
                                            <td style="padding:3px 9px;vertical-align:middle">{{number_format($item->price,0,' ','.')}}đ</td>
                                            <td style="padding:3px 9px;vertical-align:middle">{{$item->qty}}</td>
                                            <td style="padding:3px 9px;vertical-align:middle">{{ number_format($item->total,0,' ','.') }}đ</td>
                                        </tr>
                                    @endforeach
                                    <tr style="height:12px;background:#f00;line-height:26px;font-size:14px">
                                        <td colspan="4"
                                            style="text-align:left;padding:6px 9px;margin-top:30px;color:rgb(255,255,255);text-transform:uppercase;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">
                                            <strong>Tổng đơn hàng: </strong>
                                        </td>
                                        <td colspan="1"
                                            style="text-align:left;padding:6px 9px;color:rgb(255,255,255)">
                                            <strong>{{$total}}đ</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div>
                                <p>Quý khách vui lòng giữ lại hóa đơn, hộp sản phẩm và phiếu bảo hành (nếu có) để đổi
                                    trả hàng hoặc bảo hành khi cần thiết.</p>
                                <p>Liên hệ Hotline <strong style="color:#099202">0123.456.789</strong> (8-21h cả T7,CN).
                                </p>
                                <p><strong>Unimart cảm ơn quý khách đã đặt hàng, chúng tôi sẽ không ngừng nổ lực để phục
                                        vụ quý khách tốt hơn!</strong></p>
                                <div style="height:auto">
                                    <p>
                                        Quý khách nhận được email này vì đã dùng email này đặt hàng tại cửa hàng trực
                                        tuyến Unimart.
                                        <br>
                                        Nếu không phải quý khách đặt hàng vui lòng liên hệ số điện thoại 0123.456.789
                                        hoặc email <a style="color:#4b8da5">2002nnn@gmail.com</a> để hủy đơn hàng
                                    </p>
                                    <div class="yj6qo"></div>
                                    <div class="adL">

                                    </div>
                                </div>
                                <div class="adL">
                                </div>
                            </div>
                            <div class="adL">
                            </div>
                        </div>
                        <div class="adL">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id=":ue" class="ii gt" style="display:none">
        <div id=":uf" class="a3s aiL "></div>
    </div>
    <div class="hi"></div>
</div>
