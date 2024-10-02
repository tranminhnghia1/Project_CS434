@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline ">
                    <form action="#">
                        <input type="text" name="keyword" class="form-control form-search"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a> {{-- fullUrlWithQuery là hàm nối vào link --}}
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hoa<span
                            class="text-muted">({{ $count[1] }})</span></a>

                </div>
                <form action="{{ url('admin/users/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $act)
                                {{-- $k là key và act là tên của hành động --}}
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach


                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Họ tên</th>

                                <th scope="col">Email</th>
                                <th scope="col">Admin|Client</th>
                                <th scope="col" style="text-align: center;">Quyền</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td>{{ $user->name }}</td>

                                        <td>{{ $user->email }}</td>
                                        @if ($user->role ===0)
                                            <td>Client</td>
                                        @elseif ($user->role===1)
                                            <td>Admin</td>
                                        @endif
                                    
                                        <td style="text-align: center;">
                                            @foreach ($user->roles as $role)
                                                <span 
                                                    class="badge badge-primary text-center mr-2">{{ $role->name }}<br></span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $user->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white"title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::id() != $user->id)
                                                <a href="{{ route('delete_user', $user->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick=" return confirm('Bạn có chắc chắn xóa không?')"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td class="text text-danger bg-white" colspan="7">Không có bản ghi nào!</td>
                                {{-- colspan là để đẩy cột này bằng 7 cột user --}}
                            @endif
                        </tbody>
                    </table>
                </form>

                {{ $users->links() }}
            </div>
        </div>
    </div>
   
@endsection
