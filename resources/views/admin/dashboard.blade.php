@extends('layouts.admin')

@section('content')
<style>
    .height-card{
        height: 72.8px; 
    }
    .cart-info{
        height: 140px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-2">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div  class="card-header height-card">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body cart-info">
                        <h5 class="card-title">{{ $count[0] }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header height-card">ĐANG VẬN CHUYỂN</div>
                    <div class="card-body cart-info">
                        <h5 class="card-title">{{ $count[1] }}  ĐƠN</h5>
                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div style="height: 72.8px;" class="card-header height-card">ĐANG XỬ LÝ</div>
                    <div class="card-body cart-info">
                        <h5 class="card-title">{{ $count[2] }}  ĐƠN</h5>
                        <p class="card-text">Đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div  class="card-header height-card">DOANH SỐ</div>
                    <div  class="card-body cart-info" >
                        <h5 class="card-title">1000Đ</h5>
                        {{-- <h5 class="card-title">{{ number_format($total_sales, 0, ',', '.') }}Đ</h5> --}}
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div   class="card-header height-card">ĐƠN HÀNG HỦY</div>
                    <div class="card-body cart-info">
                        <h5 class="card-title">{{ $count[3] }}  ĐƠN</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header height-card">TỔNG SẢN PHẨM TRONG KHO</div>
                    <div class="card-body cart-info">
                        <h5 class="card-title">{{ $total_product }} SẢN PHẨM</h5>
                        <p class="card-text">Số lượng sản phẩm trong kho</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- <canvas id="salesChart" width="400" height="200"></canvas> --}}
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col"style="text-align: center;">Khách hàng</th>
                            <th scope="col" style="text-align: center;">Số lượng sp</th>
                            <th scope="col"style="text-align: center;">Tổng tiền</th>
                            <th scope="col"style="text-align: center;">Trạng thái</th>
                            <th scope="col"style="text-align: center;">Thời gian</th>
                            <th scope="col"style="text-align: center;">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($list_order as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $t }}</td>
                                    <td><a href="{{ route('order.edit', $item->id) }}">{{ $item->order_code }}</td>
                                    <td style="text-align: center;">
                                        {{ $item->fullname }} <br>
                                        {{ $item->phone_number }}
                                    </td>

                                    <td style="text-align: center;">{{ $item->num_order }}</td>
                                    <td style="text-align: center;">{{ $item->total_price }}₫</td>
                                    <td style="text-align: center;">
                                        @if ($item->status == 'success')
                                            <span class="badge badge-success">Thành công</span>
                                        @elseif ($item->status == 'waiting')
                                            <span class="badge badge-warning">Đang vận chuyển</span>
                                        @elseif ($item->status == 'dustin')
                                            <span class="badge badge-danger">Hủy đơn</span>
                                        @elseif ($item->status == 'pending')
                                            <span class="badge badge-dark">Chờ xử lý</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $item->created_at }}</td>
                                    <td style="text-align: center;">
                                        {{-- <a href="{{ route('order.edit', $item->id) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a> --}}
                                        <a href="{{ route('order.edit', $item->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" title=""><i
                                                style="color: #fff; font-size: 17px;font-weight: bold;"
                                                class="fa-regular fa-eye"></i></a>
                                        <a href="{{ route('delete_order',$item->id) }}" class="btn btn-danger btn-sm rounded-0 text-white"
                                            type="button" title="Delete"><i
                                                onclick=" return confirm('Bạn có chắc chắn xóa không?')"
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                      
                    </tbody>
                </table>
                {{ $list_order->links() }}
            </div>
        </div>

    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['ĐƠN HÀNG THÀNH CÔNG', 'ĐANG VẬN CHUYỂN', 'ĐANG XỬ LÝ', 'ĐƠN HÀNG HỦY'],
                    datasets: [{
                        label: 'Số lượng đơn hàng',
                        data: [@json($count)],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script> --}}
@endsection
