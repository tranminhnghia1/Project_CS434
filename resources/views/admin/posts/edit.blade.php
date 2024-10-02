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
                Cập nhật bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.update',$posts ->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $posts->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug_post">Slug</label>
                        <input class="form-control" type="text" name="slug_post" id="slug_post"value="{{ $posts->slug_post }}">
                        @error('slug_post')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="thumnail">Ảnh đại diện</label>
                                <input type="file" name="upload_file" value="" class="form-control-file" id="thumnail"value="{{ $posts->thumnail }}">
                                <img style="width:200px" src="{{ asset($posts->thumnail) }}" alt="">
                                @error('upload_file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-4">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select class="form-control" id="">
                                    <option>Chọn danh mục</option>
                                    <option>Danh mục 1</option>
                                    <option>Danh mục 2</option>
                                    <option>Danh mục 3</option>
                                    <option>Danh mục 4</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="10">{{  $posts->content }}</textarea>
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
