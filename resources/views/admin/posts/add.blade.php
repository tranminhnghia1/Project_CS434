@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('statuss'))
                <div class="alert alert-success">
                    {{ session('statuss') }}
                </div>
            @endif
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ url('admin/posts/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="name" id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug_post">Slug</label>
                        <input class="form-control" type="text" name="slug_post" id="slug_post">
                        @error('slug_post')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="product_thumb">Ảnh đại diện</label>
                                <input type="file" name="upload_file" value="" class="form-control-file"
                                    id="product_thumb">
                                    <div style="height: 85px;" id="image-preview"></div>
                                @error('upload_file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select class="form-control" id="" name="parent_cat">
                                    <option>Chọn danh mục</option>
                                    @foreach ($list_add_multiple as $item)
                                        {
                                        <option value="{{ $item->id }}">
                                            {{ str_repeat('|--', $item['level']) . $item['name'] }}</option>
                                        }
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="10"></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="posted"
                                checked='checked'>
                            <label class="form-check-label" for="exampleRadios1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="waiting">
                            <label class="form-check-label" for="exampleRadios2">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror


                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
