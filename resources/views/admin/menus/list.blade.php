@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    @if (session('statuss'))
                        <div class="alert alert-success">
                            {{ session('statuss') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thêm menu
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/menus/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên menu</label>
                                <input class="form-control" type="text" name="name" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Link</label>
                                <input class="form-control" type="text" name="link" id="name">
                                @error('link')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Thứ tự</label>
                                <input class="form-control" type="text" name="parent_id" id="name">
                                @error('parent_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                        value="waiting">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                        value="posted" checked>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <form action="" method="">
                            @csrf
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên Menu</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Thứ tự</th>
                                        <th scope="col">Người tạo-Ngày tạo</th>
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t = 0;
                                    @endphp
                                    @foreach ($menus as $menu)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <td scope="row">{{ $t }}</td>
                                            <td>{{ $menu->name }}</td>
                                            <td>{{ $menu->link }}</td>
                                            <td style="text-align: center;">
                                                @if ($menu->status == 'posted')
                                                    <span class="badge badge-success">Phê duyệt</span>
                                                @elseif ($menu->status == 'waiting')
                                                    <span class="badge badge-warning">Chờ duyệt</span>
                                                @elseif ($menu->status == 'dustin')
                                                    <span class="badge badge-danger">Thùng rác</span>
                                                
                                                @endif
                                            </td>
                                            <td>{{ $menu->parent_id }}</td>
                                            <td>{{ $menu->user->name }}
                                                <p>{{ $menu->created_at }}</p>
                                            </td>

                                            <td>
                                                <a href="{{ route('menu.edit',$menu->id) }}" class="btn btn-success btn-sm rounded-0 text-white"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_menu', $menu->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick=" return confirm('Bạn có chắc chắn xóa không?')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
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
