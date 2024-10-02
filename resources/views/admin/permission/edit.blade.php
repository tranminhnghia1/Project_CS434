@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('statuss'))
            <div class="alert alert-success">
                {{ session('statuss') }}
            </div>
        @endif
        <div class="row">
            <div class="col-4">
                <div class="card">

                    <div class="card-header font-weight-bold">
                        Chỉnh sửa quyền
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => ['permission.update',$permission->id],'method'=>'post']) !!}
                        <div class="form-group">
                            {{ Form::label('name', 'Tên quyền') }}
                            {{ Form::text('name', $permission->name, ['class' => 'form-control', 'id' => 'name']) }}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{ Form::label('slug', 'Slug') }}
                            <small class="form-text text-muted pb-2">Ví dụ:posts.add</small>
                            {{ Form::text('slug', $permission->slug, ['class' => 'form-control', 'id' => 'slug']) }}
                            @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {{-- {{ Form::label('description', 'Mô tả') }}
                            {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'rows' => 3]) }} --}}
                            <label for="description">Mô tả</label>
                            <textarea name="description" value="" id="description" placeholder="description" rows="3">{{ $permission->description }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" style="margin-bottom: 10px !important">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Mô tả quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                    <!-- <th scope="col">Mô tả</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($list_permission_grouped as $moduleName => $modulePermission)
                                    <tr>
                                        <td scope="row"></td>
                                        <td><strong>Module {{ ucfirst($moduleName) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($modulePermission as $permission)
                                        <tr>
                                            <td scope="row">{{ $t++ }}</td>
                                            <td>|---{{ $permission->name }}</td>
                                            <td>{!! $permission->description !!}</td>
                                            <td>{{ $permission->slug }}</td>
                                            <td>
                                                <a href="{{ route('permission.edit', $permission->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('permission.delete', $permission->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick=" return confirm('Bạn có chắc chắn xóa không?')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{ $list_permission->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
