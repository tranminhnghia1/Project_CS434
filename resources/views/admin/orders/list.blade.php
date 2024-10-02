@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('statuss'))
                <div class="alert alert-success">
                    {{ session('statuss') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type=""name="keyword" class="form-control form-search" placeholder="Tìm theo tên khách"
                            value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
               
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'success']) }}"class="text-primary">Thành công<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'waiting']) }}" class="text-primary">Đang vận
                        chuyển<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ xử lí<span
                            class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'dustin']) }}" class="text-primary">Hủy đơn<span
                            class="text-muted">({{ $count[4] }})</span></a>
                    <a href="" class="text-primary">Doanh số<span
                            class="text-muted">({{ number_format($total_sales, 0, ',', '.') }}đ)</span></a>
                    <a href="" class="text-primary">Tổng sản phẩm trong kho<span
                            class="text-muted">({{ $total_product }})</span></a>
                    
                </div>
                <form action="{{ url('admin/orders/action') }}" method="">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $act)
                                {{-- $k là key và act là tên của hành động --}}
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall" style="margin-bottom:11px !important">
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
                            @if ($orders->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($orders as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $t }}</td>
                                        <td><a href="{{ route('order.edit', $item->id) }}">{{ $item->order_code }}</a></td>
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
                                            <a href="{{ route('delete_order', $item->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                title="Delete"><i onclick=" return confirm('Bạn có chắc chắn xóa không?')"
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td class="text text-danger bg-white" colspan="7">Không có bản ghi nào!</td>
                                {{-- colspan là để đẩy cột này bằng 7 cột user --}}
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $orders->links() }}
                <a href="{{ route('orders.export') }}" class="btn btn-success">Export to Excel</a>
            </div>
        </div>
    </div>
@endsection
