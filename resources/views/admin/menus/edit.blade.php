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
                        Cập nhật
                    </div>
                    <div class="card-body">
                        <form action="{{ route('menu.update',$menus->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên menu</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $menus->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Link</label>
                                <input class="form-control" type="text" name="link" id="name"value="{{ $menus->link }}">
                                @error('link')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Thứ tự</label>
                                <input class="form-control" type="text" name="parent_id" id="name" value="{{ $menus->parent_id }}">
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
            
    </div>
@endsection
