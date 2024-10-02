@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card">
                    @if (session('statuss'))
                        <div class="alert alert-success">
                            {{ session('statuss') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        Danh sách
                        <div class="function">
                            <a href="{{ url('admin/products/cat/add') }}"class="btn btn-success">Thêm mới</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action=""method="">
                            @csrf
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên danh mục</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Người tạo</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($list_cat_multiple as $item)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $t }}</th>
                                            <td>{{ str_repeat('|--', $item['level']) . $item['name'] }}</td>
                                            <td class="badge badge-success" style="margin-top: 9px;height: 37px;}">{{ $item->status }}</td>
                                            <td>{{ optional($item->user)->name }}</td>
                                            <td>{{ $item->created_at }}</td>

                                            <td><a href="{{ route('productCat.edit', $item->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white"title="Edit"><i
                                                        class="fa fa-edit"></i></a>

                                                <a href="{{ route('delete_productCat', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick=" return confirm('Bạn có chắc chắn xóa không?')"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody> 
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection 
