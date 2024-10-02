<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Slider;

class AdminSliderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'sliders']);
            return $next($request);
        });
    }
    function list()
    {   $sliders = Slider::all();
        return view('admin/sliders/list',compact('sliders'));
    }
    function add()
    {
        return view('admin/sliders/add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content_desc' => ['required', 'string', 'min:8'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                'slider_thumb' => ['required']


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
                'slider_thumb' => 'Ảnh đại diện'
            ]

        );
        $data = $request->all();
        if ($request->hasFile('slider_thumb')) {
            $file = $request->file('slider_thumb');
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

            'slider_thumb' => $thumnail,
            'content_desc' => $request->input('content_desc'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ];
        Slider::create($data);
        return redirect('admin/sliders/add')->with('statuss', 'Đã thêm slider thành công!');
    }
    function delete_page($id)
    {
        $sliders = Slider::find($id);
        $sliders->delete();
        return redirect('admin/sliders/list')->with('statuss', 'Đã xóa thành viên thành công!');
    }
    function edit($id){
        $sliders = Slider::find($id);
        return view('admin/sliders/edit', compact('sliders'));
    }
    function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content_desc' => ['required', 'string', 'min:8'],
                'link' => ['required', 'string', 'min:1', 'max:255'],
                'slider_thumb' => ['required']


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
                'slider_thumb' => 'Ảnh đại diện'
            ]

        );
        $data = $request->all();
        if ($request->hasFile('slider_thumb')) {
            $file = $request->file('slider_thumb');
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
        Slider::where('id', $id)->update ([

            'name' => $request->input('name'),
            'link' =>$request->input('link'),

            'slider_thumb' => $thumnail,
            'content_desc' => $request->input('content_desc'),
            'status' => $request->input('status'),

            'user_id' => Auth::id(),


        ]);
       
        return redirect('admin/sliders/list')->with('statuss', 'Đã cập nhật slider thành công!');
    }
}
