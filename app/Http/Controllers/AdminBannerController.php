<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBannerController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banners']);
            return $next($request);
        });
    }
    function list(){
        $banners = Banner::all();

        return view('admin/banners/list',compact('banners'));
    }
    function add()
    {
        return view('admin/banners/add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content_desc' => ['required', 'string', 'min:8'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                'product_thumb' => ['required']


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'content_desc' => 'Tiêu đề',
                'status' => 'Nội dung',
                'link' => 'Link thân thiện',
                'product_thumb' => 'Ảnh đại diện'
            ]

        );
        $data = $request->all();
        if ($request->hasFile('product_thumb')) {
            $file = $request->file('product_thumb');
            //lấy tên file
            $file_name = $file->getClientOriginalName();

            //lấy đuối file
            //echo $file -> getClientOriginalExtension();

            //lấy kích thước
            // echo $file -> getSize();
            //chuyển file lên sẻver
            $file->move('public/uploads', $file_name);
            $thumnail = 'uploads/' . $file_name;
            //$data['thumnail'] = $thumnail;
            // $post=Post::create($data);
        }
        $data = [

            'name' => $request->input('name'),
            'link' =>$request->input('link'),

            'product_thumb' => $thumnail,
            'content_desc' => $request->input('content_desc'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ];
        Banner::create($data);
        
        return redirect('admin/banners/add')->with('statuss', 'Đã thêm banner thành công!');
    }

    function delete_banner($id)
    {
        $banners = Banner::find($id);
        $banners->delete();
        return redirect('admin/banners/list')->with('statuss', 'Đã xóa thành viên thành công!');
    }
    function edit($id){
        $banners = Banner::find($id);
        return view('admin/banners/edit', compact('banners'));
    }
    function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content_desc' => ['required', 'string', 'min:8'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                'product_thumb' => ['required']


            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên trang',
                'content_desc' => 'Tiêu đề',
                'status' => 'Nội dung',
                'link' => 'Link thân thiện',
                'product_thumb' => 'Ảnh đại diện'
            ]

        );
        $data = $request->all();
        if ($request->hasFile('product_thumb')) {
            $file = $request->file('product_thumb');
            //lấy tên file
            $file_name = $file->getClientOriginalName();

            //lấy đuối file
            //echo $file -> getClientOriginalExtension();

            //lấy kích thước
            // echo $file -> getSize();
            //chuyển file lên sẻver
            $file->move('public/uploads', $file_name);
            $thumnail = 'uploads/' . $file_name;
            //$data['thumnail'] = $thumnail;
            // $post=Post::create($data);
        }
        Banner::where('id', $id)->update ([

            'name' => $request->input('name'),
            'link' =>$request->input('link'),

            'product_thumb' => $thumnail,
            'content_desc' => $request->input('content_desc'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ]);
       
        return redirect('admin/banners/list')->with('statuss', 'Đã cập nhật banner thành công!');
    }
}
