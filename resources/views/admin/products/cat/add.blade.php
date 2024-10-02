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
                    <div class="card-header font-weight-bold">
                       Thêm Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/products/cat/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="name" >
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug_catPost">Slug</label>
                                <input class="form-control" type="text" name="slug_productCat" id="slug_catPost">
                                @error('slug_productCat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select class="form-control" id="" name="parent_cat">
                                    <option value="0">Chọn danh mục</option>
                                    @foreach ($list_add_cat_multiple as $item)
                                        {
                                        <option value="{{ $item->id }}">
                                            {{ str_repeat('|--', $item['level']) . $item['name'] }}</option>
                                        }
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                        value="posted" checked='checked'>
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
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
@endsection
