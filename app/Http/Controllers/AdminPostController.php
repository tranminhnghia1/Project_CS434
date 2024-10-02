<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_cat;
use App\Models\User;
use App\Models\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stringable;
use Illuminate\Support\Str;


class AdminPostController extends Controller
{
    
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        
        // $posts = User::find(1)
        
        // ->posts; 
        // return $posts;
        //  $users = Post::find(3)
        
        // ->users; 
        // return $users;
        
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
                $posts = Post::where('status', '=', 'posted')->paginate(5);
            }
            if ($status == 'waiting') {
                $list_act = [

                    'posted' => 'Phê duyệt',
                    'dustin' => 'Bỏ vào Thùng rác'
                ];
                $posts = Post::where('status', '=', 'waiting')->paginate(10);
            }
            if ($status == 'dustin') {
                $list_act = [

                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $posts = Post::onlyTrashed()->paginate(10);
            }
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $posts = Post::where('name', 'LIKE', "%{$keyword}%")->withTrashed()->paginate(5);
        }
        $count_user_active = Post::withTrashed()->count();
        $count_user_poster = Post::where('status', '=', 'posted')->count();
        $count_user_waiting = Post::where('status', '=', 'waiting')->count();
        $count_user_trash = Post::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_poster, $count_user_waiting, $count_user_trash];
      
        return view('admin.posts.list', compact('posts', 'count', 'list_act'));
        
    }
    function add()
    {
        $list_add = Post_cat::all();
        $list_add_multiple = data_tree($list_add);

        return view('admin/posts/add',compact('list_add_multiple'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'slug_post' => ['required', 'string', 'min:3', 'max:255'],
                'upload_file' => ['required']

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên bài viết',
                'content' => 'Nội dung',
                'status' => 'Trạng thái',
                'slug_post' => 'Link thân thiện',
                'upload_file' => 'Ảnh đại diện'
            ]

        );

        $data = $request->all();
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
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
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'cat_id' => $request->input('parent_cat'),
            'thumnail' => $thumnail,
            'slug_post' => Str::slug($request->input('slug_post')),
            'user_id'=>Auth::id(),
        ];

        Post::create($data);

        return redirect('admin/posts/list')->with('statuss', 'Đã thêm thành viên thành công!');
    }

    function action(Request $request){
        $list_check = $request->input('list_check');

        if ($list_check) {
            
            
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'dustin') {
                    Post::where('id', $list_check)
                    ->update([ 'status' =>'dustin'
                        
                    ]);
                    //
                    Post::destroy($list_check);
                    
                    
                    
                    return redirect('admin/posts/list')->with('statuss', 'Bạn đã xóa thành công');
                }

                if ($act == 'forceDelete') {
                    Post::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/posts/list')->with('statuss', 'Bạn đã xóa vĩnh viễn  thành công');
                }
                if ($act == 'restore') {
                   
                    //
                    Post::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    
                    //
                    Post::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/posts/list')->with('statuss', 'Bạn đã khôi phục  thành công');
                }
                if($act == 'posted'){
                    Post::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/posts/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                if($act == 'waiting'){
                    Post::where('id', $list_check)
                    ->update([ 'status' =>'waiting'
                        
                    ]);
                    return redirect('admin/posts/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                // if($act == 'dustin'){
                //     Page::where('id', $list_check)
                //     ->update([ 'status' =>'dustin'
                        
                //     ]);
                //     return redirect('admin/posts/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                // }
            }
        } else {
            return redirect('admin/posts/list')->with('statuss', 'Bạn cần chọn phần tử để thực thi');
        }
    }
    function delete_page($id)
    {
        $posts = Post::find($id);
        $posts->delete();
        return redirect('admin/posts/list')->with('statuss', 'Đã xóa thành viên thành công!');
    }
    
    function edit($id){
        $posts = Post::withTrashed()->find($id);
        return view('admin/posts/edit', compact('posts'));
    }
    function update(Request $request, $id){
        
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'slug_post' => ['required', 'string', 'min:3', 'max:255'],


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
                'slug_post' => 'Link thân thiện'
            ]

        );
        $data = $request->all();
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
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
        Post::where('id', $id)->update ([
            'name' => $request->input('name'),
           'thumnail' =>$thumnail,
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'slug_post' => Str::slug($request->input('slug_post'))

        ]);
        return redirect('admin/posts/list')->with('statuss', 'Đã cập nhật bài viết thành công!');
    }

    //===========================================Danh mục===================
    function listCat()
    {   
        // $post_cat = Post_cat::all();
        // return $post_cat;
        // $posts = Post_cat::find(1)
        // ->posts; 
        // return $posts;
        $list_cat = Post_cat::all();
       //eturn $source;
       $list_cat_multiple = data_tree($list_cat);
       
      
       
        return view('admin/posts/cat/list',compact('list_cat_multiple'));
    }
    function list_add_Cat()
    {   
        // $post_cat = Post_cat::all();
        // return $post_cat;
        // $posts = Post_cat::find(1)
        // ->posts; 
        // return $posts;
        $list_add_cat = Post_cat::all();
       //eturn $source;
       $list_add_cat_multiple = data_tree($list_add_cat);
       
      
       
        return view('admin/posts/cat/add',compact('list_add_cat_multiple'))->with('statuss', 'Đã thêm  danh mục bài viết thành công thành công!');
    }
    function storeCat(Request $request){
      
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'slug_postCat' => ['required', 'string', 'min:8'],
                //'parent_cat' => ['required'],
                'status' => ['required'],
                
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên bài viết',
                'slug_postCat' => 'Link thân thiện',
                'status' => 'Trạng thái',
                //'parent_cat' => 'Danh mục cha',
                
            ]

        );
        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'parent_cat' => $request->input('parent_cat'),
            
            'slug_postCat' => Str::slug($request->input('slug_postCat')),
            'user_id'=>Auth::id()
        ];
        Post_cat::create($data);
        return redirect('admin/posts/cat/list')->with('statuss', 'Đã thêm  danh mục mới thành công!');
    }
    function delete_cat($id)
    {
        $posts = Post_cat::find($id);
        $posts->delete();
        return redirect('admin/posts/cat/list')->with('statuss', 'Đã xóa danh mục thành công!');
    }
    function editCat($id){
        $list_edit_cat = Post_cat::find($id);
       //eturn $source;
       $list_update = Post_cat::all();
       $list_edit_cat_multiple = data_tree($list_update);
        
        return view('admin/posts/cat/edit', compact('list_edit_cat_multiple','list_edit_cat'));
    }
    function updateCat(Request $request, $id){
        
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'slug_postCat' => ['required', 'string', 'min:8'],
                'parent_cat' => ['required'],
                'status' => ['required'],
                
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'

            ],
            [
                'name' => 'Tên bài viết',
                'slug_postCat' => 'Link thân thiện',
                'status' => 'Trạng thái',
                'parent_cat' => 'Danh mục cha',
                
            ]

        );
        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'parent_cat' => $request->input('parent_cat'),
            
            'slug_postCat' => Str::slug($request->input('slug_postCat')),
            'user_id'=>Auth::id()
        ];
        Post_cat::where('id', $id)->update($data);
        
            
       
        return redirect('admin/posts/cat/list')->with('statuss', 'Đã cập nhật bài viết thành công!');
    }
  
}
