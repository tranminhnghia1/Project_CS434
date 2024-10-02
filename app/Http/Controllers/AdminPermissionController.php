<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
class AdminPermissionController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }
    function add(){
        $list_permissions = Permission::paginate(10);
        $list_permission_grouped = Permission::all()->groupBy(function ($list_permission_grouped) {
            return explode('.', $list_permission_grouped->slug)[0];
        });
        // $list_permission = Permission::paginate(10)->groupBy(function ($list_permission) {
        //     return explode('.', $list_permission->slug)[0]; //chia ra hai bên bởi dấu chấm để phân mục,nhóm
        //     //module.action
        //     //0=>module
        //     //1=>action
        // });
        
        


        return view('admin/permission/add', compact('list_permissions','list_permission_grouped'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:255'],
                'slug' => ['required', 'string', 'min:1', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Link thân thiện',
            ]

        );
        
        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('permission.add')->with('statuss', 'Đã thêm quyền thành công!');;
    }
    function edit($id){
        $permission = Permission::find($id);
        $list_permission = Permission::paginate(10);
        $list_permission_grouped = $list_permission->groupBy(function ($list_permission) {
            return explode('.', $list_permission->slug)[0];
        });
        return view('admin/permission/edit', compact('permission','list_permission','list_permission_grouped'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:255'],
                'slug' => ['required', 'string', 'min:1', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Link thân thiện',
            ]

        );
        Permission::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('permission.add')->with('statuss', 'Đã cập nhật quyền thành công!');;
    }
    function delete($id){
        Permission::where('id',$id)->delete();
        return redirect()->route('permission.add')->with('statuss', 'Đã xóa quyền thành công!');;
    }
}
