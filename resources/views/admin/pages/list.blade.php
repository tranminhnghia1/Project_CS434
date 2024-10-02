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
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" name="keyword" class="form-control form-search"
                            placeholder="Tìm kiếm"value="{{ request()->input('keyword') }}">
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
                <form action="{{ url('admin/pages/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="act">
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

                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Ngày cập nhật gần nhất</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td scope="row"> <a href="{{ route('page.edit', $page->id) }}">{{ $page->name }}</a></td>
                                        <td><a href="">{{ $page->user->name }}</a>
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($page->status == 'posted')
                                                <span class="badge badge-success">Phê duyệt</span>
                                            @elseif ($page->status == 'waiting')
                                                <span class="badge badge-warning">Chờ duyệt</span>
                                            @elseif ($page->status == 'dustin')
                                                <span class="badge badge-danger">Thùng rác</span>
                                            
                                            @endif
                                        </td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>{{ $page->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('page.edit', $page->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white"title="Edit"><i
                                                    class="fa fa-edit"></i></a>

                                            <a href="{{ route('delete_page', $page->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white"
                                                onclick=" return confirm('Bạn có chắc chắn xóa không?')" title="Delete"><i
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
                {{ $pages->links() }}
            </div>


        </div>
    </div>
    {{-- <style>
        td.span.badge{
            height: 25px;
        font-size: 13px;
        width: 67px;
        }
        
    </style> --}}
@endsection
