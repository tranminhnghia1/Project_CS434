@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            <div class="card-body">
                <form action="{{ url('admin/users/store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirmed">Xác nhận Mật khẩu</label>
                        <input class="form-control" type="password" name="confirmed" id="confirmed">
                        @error('confirmed')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_admin" value="1"
                            checked>
                        <label class="form-check-label" for="role_admin">
                            Là Admin
                        </label>
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Nhóm quyền <span style="font-size: 12px;color: red;">(có thể nhấn ctrl+chuột
                                để chọn nhiều quyền)</span></label>
                        <select class="form-control select2_init" multiple="multiple" id="" name="role[]">
                            {{-- <option value="">Chọn quyền </option> --}}
                            {{-- @foreach ($role as $key => $r)
                                <option value="{{ $r->name }}" name="role" id="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach 

                            @php
                                $selectedRoles = $user->roles->pluck('id')->toArray();
                                $options = $roles->pluck('name', 'id')->toArray();
                            @endphp
                            <select name="roles[]" id="roles" class="form-control" multiple>
                                @foreach ($options as $id => $name)
                                    <option value="{{ $id }}" @if (in_array($id, $selectedRoles)) selected @endif>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </select>
                    </div> --}}

                    <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- chọn nhiều select option phân quyền --}}
    <script>
        $(document).ready(function() {
            $('.select2_init').select2({
                'placeholder': 'Chọn quyền'
            });
        });
    </script>
@endsection
