<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMenuController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'menus']);
            return $next($request);
        });
    }

    function list(){
        $menus = Menu::all();
        return view('admin/menus/list',compact('menus'));
    }

    
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'parent_id' => ['required'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'parent_id' => 'Thứ tự',
                'status' => 'Trạng thái',
                'link' => 'Link thân thiện',
                
            ]

        );
        
        $data = [

            'name' => $request->input('name'),
            'link' =>$request->input('link'),

            
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ];
        Menu::create($data);
        
        return redirect('admin/menus/list')->with('statuss', 'Đã thêm menu thành công!');
    }

    function delete_menu($id){
        $menus = Menu::find($id);
        $menus->delete();
        return redirect('admin/menus/list')->with('statuss', 'Đã xóa menu thành công!');
    }

    function edit($id){
        $menus=Menu::find($id);
        return view('admin/menus/edit', compact('menus'));
    }
    
    function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'parent_id' => ['required'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'parent_id' => 'Thứ tự',
                'status' => 'Trạng thái',
                'link' => 'Link thân thiện',
                
            ]

        );
        
        Menu::where('id',$id)->update( [

            'name' => $request->input('name'),
            'link' =>$request->input('link'),

            
            'parent_id' => $request->input('parent_id'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ]);
        
        
        return redirect('admin/menus/list')->with('statuss', 'Đã cập nhật menu thành công!');
    }
}
