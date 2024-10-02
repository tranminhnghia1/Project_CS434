<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'posted' => 'Phê duyệt',
            'waiting' => 'Chờ duyệt',
            'dustin' => 'Bỏ vào Thùng rác'
        ];
        if ($status == 'posted' || $status == 'waiting' || $status == 'dustin') {
            if ($status == 'posted') {
                $list_act = [

                    'waiting' => 'Chờ duyệt',
                    'dustin' => 'Bỏ vào Thùng rác'
                ];
                $pages = Page::where('status', '=', 'posted')->paginate(10);
            }
            if ($status == 'waiting') {
                $list_act = [

                    'posted' => 'Phê duyệt',
                    'dustin' => 'Bỏ vào Thùng rác'
                ];
                $pages = Page::where('status', '=', 'waiting')->paginate(10);
            }
            if ($status == 'dustin') {
                $list_act = [

                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $pages = Page::onlyTrashed()->paginate(10);
            }
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('name', 'LIKE', "%{$keyword}%")->withTrashed()->paginate(5);
        }
        $count_user_active = Page::withTrashed()->count();
        $count_user_poster = Page::where('status', '=', 'posted')->count();
        $count_user_waiting = Page::where('status', '=', 'waiting')->count();
        $count_user_trash = Page::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_poster, $count_user_waiting, $count_user_trash];

        return view('admin.pages.list', compact('pages', 'count', 'list_act'));
    }
    function add()
    {

        return view('admin.pages.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'slug_page' => ['required', 'string', 'min:3', 'max:255'],


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'content' => 'Tiêu đề',
                'status' => 'Nội dung',
                'slug_page' => 'Link thân thiện'
            ]

        );
        Page::create([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'slug_page' => Str::slug($request->input('slug_page'))

        ]);
        return redirect('admin/pages/add')->with('statuss', 'Đã thêm thành viên thành công!');
    }
    
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check) {
            
            
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'dustin') {
                    Page::where('id', $list_check)
                    ->update([ 'status' =>'dustin'
                        
                    ]);
                    //
                    Page::destroy($list_check);
                    
                    
                    
                    return redirect('admin/pages/list')->with('statuss', 'Bạn đã xóa thành công');
                }

                if ($act == 'forceDelete') {
                    Page::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/pages/list')->with('statuss', 'Bạn đã xóa vĩnh viễn  thành công');
                }
                if ($act == 'restore') {
                   
                    //
                    Page::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    
                    //
                    Page::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/pages/list')->with('statuss', 'Bạn đã khôi phục  thành công');
                }
                if($act == 'posted'){
                    Page::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/pages/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                if($act == 'waiting'){
                    Page::where('id', $list_check)
                    ->update([ 'status' =>'waiting'
                        
                    ]);
                    return redirect('admin/pages/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                // if($act == 'dustin'){
                //     Page::where('id', $list_check)
                //     ->update([ 'status' =>'dustin'
                        
                //     ]);
                //     return redirect('admin/pages/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                // }
            }
        } else {
            return redirect('admin/pages/list')->with('statuss', 'Bạn cần chọn phần tử để thực thi');
        }
    }

    function delete_page($id)
    {
        $pagess = Page::find($id);
        $pagess->delete();
        return redirect('admin/pages/list')->with('statuss', 'Đã xóa thành viên thành công!');
    }


    function edit($id){
        $pages = Page::withTrashed()->find($id);
        return view('admin/pages/edit', compact('pages'));
    }
    function update(Request $request, $id){
        
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'slug_page' => ['required', 'string', 'min:3', 'max:255'],


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'content' => 'Tiêu đề',
                'status' => 'Nội dung',
                'slug_page' => 'Link thân thiện'
            ]

        );
        Page::where('id', $id)->update ([
            'name' => $request->input('name'),
           
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'slug_page' => Str::slug($request->input('slug_page'))

        ]);
        return redirect('admin/pages/list')->with('statuss', 'Đã cập nhật thành viên thành công!');
    }
}
