<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    //
    

    
    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    
    function list(Request $request)
    {

        $status = $request->input('status');
        $list_act = ['delete' => 'xóa tạm thời']; // ở trang thái thì kích hoạt thì cho chỉ hiện thaqnwgf này
        if ($status == 'trash') {
            $list_act = [ //ở trạng thái vô hiệu hóa cho hiện hai thằng này
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];

            $users = User::onlyTrashed()->paginate(10);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        
        
        return view('admin.users.list', compact('users', 'count', 'list_act'));
    }
    function add()
    {
        return view('admin.users.add');
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:8', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => 'required|string|min:8','confirmed',
                'role' => 'required|in:0,1', // Ensure role is either 0 (client) or 1 (admin)
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'xác nhận mật khẩu không thành công'

            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role' => 'Là Admin'
            ]

        );
       $user =  User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),

        ]);
        
        return redirect('admin/users/list')->with('status', 'Đã thêm thành viên thành công!');
    }
    function delete_user($id)
    {
        if (Auth::id() != $id) { //nếu id này khác với id mình đang đăng nhập vào mới được xóa, còn là id mình đang đăng nhập thì ko cho xóa
            $user = User::find($id);
            $user->delete();
            return redirect('admin/users/list')->with('status', 'Đã xóa thành viên thành công!');
        } else {
            return redirect('admin/users/list')->with('status', 'Bạn không thể tự xóa chính mình ra khỏi hệ thống!');
        }
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check'); //gửi yêu cầu đến check box để thực thi nó
        if ($list_check) {
            foreach ($list_check as $k => $id) { //dùng vopngf lặp duyệt nếu mà chính tk đang đăng nhập thì unset check box ko cho nó thực thi tk đang ĐN
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act'); //gửi yêu cầu đến  tác vụ để thực thi
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/users/list')->with('status', 'Bạn đã xóa thành công');
                }



                if ($act == 'forceDelete') {
                    User::withTrashed() //hàm khooii phục all kể cả xóa tạm thời
                        ->whereIn('id', $list_check) //điều kiện xóa  id thuộc vào tập hợp cảu listcheck
                        ->forceDelete();
                    return redirect('admin/users/list')->with('status', 'Bạn đã xóa vĩnh viễn thành công');
                }

                if ($act == 'restore') {
                    User::withTrashed() //hàm khooii phục all kể cả xóa tạm thời
                        ->whereIn('id', $list_check) //điều kiện để id thuộc vào tập hợp cảu listcheck
                        ->restore();
                    return redirect('admin/users/list')->with('status', 'Bạn đã khôi phục thành công');
                }
            }
            return redirect('admin/users/list')->with('status', 'Bạn không thể xóa tài khoản của chính bạn');
        } else {
            return redirect('admin/users/list')->with('status', 'Bạn cần chọn phần tử để thực thi');
        }
    }

    function edit(User $user){
        $roles = Role::all();
        return view('admin/users/edit', compact('user','roles'));
    }

    function update(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:8', 'max:255'],
               
                'password' => 'required|string|min:8','confirmed',
                
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                 'confirmed' => 'xác nhận mật khẩu không thành công'

            ],
            [
                'name' => 'Tên người dùng',
                
                'password' => 'Mật khẩu',
                
            ]

        );
        $user->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->roles()->sync($request->input('roles'));
       
        return redirect('admin/users/list')->with('status', 'Đã cập nhật thành viên thành công!');
    }

    //quyền
    // public function phanquyen($id)
    // {
    //     //
    //     // Role::create(['name'=>'guest']);
    //     // Permission::create(['name'=>'List Product']);
    //     // $role = Role::find(1);
    //     // $permission = Permission::find(4);
    //     //$role->givePermissionTo($permission);
    //    // auth()->user()->assignRole('admin');
    //    $user = User::find($id);
    //     $role=Role::orderBy('id','DESC')->get();
    //     $all_column_roles = $user->roles->first();
    //     return view('admin/users/role',compact('role','user','all_column_roles'));
    // }

   
}
