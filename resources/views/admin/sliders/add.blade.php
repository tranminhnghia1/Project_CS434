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
                Thêm Slider
            </div>
            <div class="card-body">
                <form action="{{ url('admin/sliders/store') }}" method="POST"enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label class="text-strong" for="title">Tiêu đề</label>
                            <input type="text" name="name" class="form-control" value="" id="title">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-strong" for="product_thumb">Ảnh</label>
                            <input type="file" name="slider_thumb" class="form-control-file" id="product_thumb">
                            <div style="height: 85px;" id="image-preview"></div>
                            @error('slider_thumb')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-strong" for="description">Mô tả ngắn</label>
                            <input type="text" name="content_desc" value="" class="form-control" id="description">
                            @error('content_desc')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-strong" for="link">Link</label>
                            <input type="text" name="link" value="" class="form-control" id="link">
                            @error('link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="text-strong" for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                    value="waiting">
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked="checked" type="radio" name="status"
                                    id="exampleRadios2" value="posted">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
