@extends('layouts.admin')

@section('content')
    {{-- @can('List banner') --}}
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('statuss'))
                <div class="alert alert-success">
                    {{ session('statuss') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type=""name="keyword" class="form-control form-search" placeholder="Tìm kiếm"
                            value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'posted']) }}"class="text-primary">Phê duyệt<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'waiting']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'dustin']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/products/action') }}" method="">
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
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo-Ngày cập nhật</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($lists->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($lists as $list)
                                    @php
                                        $t++;
                                    @endphp

                                    <tr class="">
                                        <td>
                                            <input type="checkbox"name="list_check[]" value="{{ $list->id }}">
                                        </td>
                                        <td>{{ $t }}</td>

                                        <td><img style="width: 110px;height: 100px;"
                                                src="{{ asset($list->product_thumb) }}" alt=""></td>
                                        <td><a
                                                href="{{ route('product.edit', $list->id) }}">{{ Str::of($list->name)->limit(22) }}</a>
                                        </td>
                                        <td>{{ number_format($list->price_product, 0, ',', '.') }}vnđ</td>
                                        <td>{{ optional($list->product_cat)->name }}</td>
                                        <td>{{ $list->created_at }}
                                            <p>{{ $list->updated_at }}</p>
                                        </td>
                                        <td>{{ optional($list->user)->name }}</td>

                                        <td style="text-align: center;">
                                            @if ($list->status == 'posted')
                                                <span class="badge badge-success">Phê duyệt</span>
                                            @elseif ($list->status == 'waiting')
                                                <span class="badge badge-warning">Chờ duyệt</span>
                                            @elseif ($list->status == 'dustin')
                                                <span class="badge badge-danger">Thùng rác</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('product.edit', $list->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete_post', $list->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white"
                                                onclick=" return confirm('Bạn có chắc chắn xóa không?')" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
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
                {{ $lists->links() }}
                <a href="{{ route('products.export') }}" class="btn btn-success">Export to Excel</a>
            </div>
        </div>
    </div>

    <style>
        td.span.badge {
            height: 25px;
            font-size: 13px;
            width: 67px;
        }


        .pagination li {
            /* Định nghĩa các thuộc tính CSS của bạn tại đây */
            width: 100px
        }

        .pagination .active {
            /* Định nghĩa các thuộc tính CSS của bạn tại đây */
            width: 100px
        }

        .pagination .disabled {
            /* Định nghĩa các thuộc tính CSS của bạn tại đây */
        }

        .pagination span svg{
            width: 100px !important;
        }
    </style>
    {{-- @else
        <p> Nội dung cho người dùng không có quyền List Product</p>
    @endcan --}}
@endsection
