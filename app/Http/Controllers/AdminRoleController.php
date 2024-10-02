<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class AdminRoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
        
    }
    function list(){
        // if(!Gate::allows('product.list')){
        //     abort(403);
        // }
        //return Auth::user()->hasPermission('product.edit');
        $roles = Role::all();
        return view('admin/role/list',compact('roles'));
    }
    function add(){
        $permissions = Permission::all()->groupBy(function ($permissions) {
            return explode('.', $permissions->slug)[0];
        });
        return view('admin/role/add',compact('permissions'));
    }
    function store(Request $request){
        $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:255'], //,'unique:roles,name'
                'description' => ['required'],
                'permission_id' => 'nullable|array',
                'permission_id.*' => 'exists:permissions,id'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'unique' =>':attribute đã tồn tại'
            ],
            [
                'name' => 'Tên vai trò',
                
                'description' => 'Mô tả vai trò',
            ]

        );
       $role= Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $role->permissions()->attach($request->input('permission_id'));
        return redirect()->route('role.list')->with('statuss', 'Đã thêm vai trò thành công!');
    }

    function edit(Role $role){
        
        $permissions = Permission::all()->groupBy(function ($permissions) {
            return explode('.', $permissions->slug)[0];
        });
        return view('admin/role/edit',compact('role','permissions'));
    }
    function update(Request $request, Role $role){
        $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:255'],//,'unique:roles,name'
                'description' => ['required'],
                'permission_id' => 'nullable|array',
                'permission_id.*' => 'exists:permissions,id'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'unique' =>':attribute đã tồn tại'
            ],
            [
                'name' => 'Tên vai trò',             
                'description' => 'Mô tả vai trò',
            ]
        );
       $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $role->permissions()->sync($request->input('permission_id',[]));
        return redirect()->route('role.list')->with('statuss', 'Đã cập nhật vai trò thành công!');
    }
    function delete(Role $role){
        $role->delete();
        return redirect()->route('role.list')->with('statuss', 'Đã xóa vai trò thành công!');;
    }
}
