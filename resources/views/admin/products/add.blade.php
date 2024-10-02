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
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ url('admin/products/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Tên sản phẩm</label>
                                            <input class="form-control" type="text" name="name" id="name">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Slug">Slug</label>
                                            <input class="form-control" type="text" name="slug_product" id="Slug">
                                            @error('slug_product')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="price_product">Giá</label>
                                            <input class="form-control" type="text" name="price_product"
                                                id="price_product">
                                            @error('price_product')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="discount_product">Giảm giá %</label>
                                            <input class="form-control" type="text" name="discount_product"
                                                id="price_product">
                                            @error('discount_product')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-strong" for="num">Số lượng</label>
                                            <input class="form-control" min="0" value="" type="number"
                                                name="number_product"id="num">
                                            @error('number_product')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Trạng thái</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="exampleRadios1" value="waiting">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Chờ duyệt
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="exampleRadios2" value="posted" checked>
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Công khai
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label style="padding-left: 19px;" class="text-strong" for="">Nổi
                                                    bật</label>
                                                <div class="form-check">
                                                    <input type="checkbox" value="1" name="featured" id="featured">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_thumb">Ảnh đại diện</label>
                                                <input type="file" name="product_thumb" value=""
                                                    class="form-control-file" id="product_thumb">
                                                <div style="height: 85px;" id="image-preview"></div>
                                                @error('product_thumb')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_image">Ảnh mô tả</label>
                                                <input type="file" name="product_image[]" value=""
                                                    class="form-control-file" id="product_image" multiple>
                                                <div style="height: 85px;" id="images-preview-container"></div>
                                                @error('product_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Danh mục</label>
                                                <select class="form-control" id="" name="parent_cat">
                                                    <option value="0">Chọn danh mục</option>
                                                    @foreach ($list_add_multiple as $item)
                                                        {
                                                        <option value="{{ $item->id }}">
                                                            {{ str_repeat('|--', $item['level']) . $item['name'] }}
                                                        </option>
                                                        }
                                                    @endforeach
                                                </select>
                                                @error('parent_cat')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="intro">Chi tiết sản phẩm</label>
                        <textarea name="content_desc" class="form-control" id="intro" cols="30" rows="10"></textarea>
                        @error('content_desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="intro">Mô tả sản phẩm</label>
                        <textarea name="content" class="form-control" id="intro" cols="30" rows="10"></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
    
    
@endsection
