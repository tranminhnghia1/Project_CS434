<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_cat;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stringable;
use Illuminate\Support\Str;
use App\Models\User;
class AdminProductController extends Controller
{
    //
    
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    function list(Request $request){
       
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
                $lists = Product::where('status', '=', 'posted')->paginate(5);
            }
            if ($status == 'waiting') {
                $list_act = [

                    'posted' => 'Phê duyệt',
                    'dustin' => 'Bỏ vào Thùng rác'
                ];
                $lists = Product::where('status', '=', 'waiting')->paginate(10);
            }
            if ($status == 'dustin') {
                $list_act = [

                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                $lists = Product::onlyTrashed()->paginate(10);
            }
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $lists = Product::where('name', 'LIKE', "%{$keyword}%")->withTrashed()->paginate(5);
        }
        $count_user_active = Product::withTrashed()->count();
        $count_user_poster = Product::where('status', '=', 'posted')->count();
        $count_user_waiting = Product::where('status', '=', 'waiting')->count();
        $count_user_trash = Product::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_poster, $count_user_waiting, $count_user_trash];
        
        // return $images;
        // if (auth()->user()->hasPermissionTo('List Product')) {
            // Người dùng có quyền truy cập vào tài nguyên này
            return view('admin/products/list',compact('lists','count','list_act'));
        // } else {
        //     // Người dùng không có quyền truy cập vào tài nguyên này
        //     abort(403, 'Bạn không có quyền truy cập trang này');
        // }
        
    }
    function action(Request $request){
        $list_check = $request->input('list_check');

        if ($list_check) {
            
            
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'dustin') {
                    Product::where('id', $list_check)
                    ->update([ 'status' =>'dustin'
                        
                    ]);
                    //
                    Product::destroy($list_check);
                    
                    
                    
                    return redirect('admin/products/list')->with('statuss', 'Bạn đã xóa thành công!');
                }

                if ($act == 'forceDelete') {
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/products/list')->with('statuss', 'Bạn đã xóa vĩnh viễn  thành công!');
                }
                if ($act == 'restore') {
                   
                    //
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    
                    //
                    Product::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/products/list')->with('statuss', 'Bạn đã khôi phục  thành công!');
                }
                if($act == 'posted'){
                    Product::where('id', $list_check)
                    ->update([ 'status' =>'posted'
                        
                    ]);
                    return redirect('admin/products/list')->with('statuss', 'Bạn đã thay đổi trạng thái công khai thành công!');
                }
                if($act == 'waiting'){
                    Product::where('id', $list_check)
                    ->update([ 'status' =>'waiting'
                        
                    ]);
                    return redirect('admin/products/list')->with('statuss', 'Bạn đã thay đổi trạng thái chờ duyệt thành công!');
                }
                // if($act == 'dustin'){
                //     Page::where('id', $list_check)
                //     ->update([ 'status' =>'dustin'
                        
                //     ]);
                //     return redirect('admin/products/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                // }
            }
        } else {
            return redirect('admin/products/list')->with('statuss', 'Bạn cần chọn phần tử để thực thi!');
        }
    }




    function add(){
        $list_add = Product_cat::all();
        $list_add_multiple = data_tree($list_add);
        return view('admin/products/add',compact('list_add_multiple'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'content_desc' => ['required', 'string', 'min:8'],
                'slug_product' => ['required', 'string', 'min:3', 'max:255'],
                'product_thumb' => ['required'],
                'product_image' => ['required','max:2048'],
                'number_product' => ['required'],
                'price_product' => ['required'],
                
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
                'content_desc' => 'Chi tiết sản phẩm',
                'status' => 'Trạng thái',
                'slug_product' => 'Link thân thiện',
                'product_thumb' => 'Ảnh đại diện',
                'product_image' => 'Ảnh mô tả',
                'number_product' => 'Số lượng sản phẩm',
                'price_product' => 'Giá sản phẩm',
                
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
        $files=[];
        if ($request->hasFile('product_image')) {
          //  $images = $request->file('product_image');
           
           
            foreach($request->file('product_image') as $image){
               $name = time().rand(1,100).'.'.$image->extension();
              $image-> move('public/uploads',$name);
                $files[] = $name;
            }
            $images_url = json_encode($files);
           
        }
        
        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'slug_product' => Str::slug($request->input('slug_product')),
            'price_product' => $request->input('price_product'),
            'number_product' => $request->input('number_product'),
            'featured' => $request->input('featured'),
            'content_desc' => $request->input('content_desc'),
            'cat_id' => $request->input('parent_cat'),
            'product_thumb' => $thumnail,
            'product_image' => $images_url,
            'discount'=>$request->input('discount_product'),
            'user_id'=>Auth::id(),
        ];
        Product::create($data);
        
        return redirect('admin/products/add')->with('statuss', 'Đã thêm sản phẩm thành công!');
    }
    function delete_page($id)
    {
        $products = Product::find($id);
        $products->delete();
        return redirect('admin/products/list')->with('statuss', 'Đã xóa sản phẩm thành công!');
    }
    function edit($id){
        $products = Product::withTrashed()->find($id);
        return view('admin/products/edit', compact('products'));
    }
    function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'content' => ['required', 'string', 'min:8'],
                'content_desc' => ['required', 'string', 'min:8'],
                'slug_product' => ['required', 'string', 'min:3', 'max:255'],
                'product_thumb' => ['required'],
                'product_image' => ['required','max:2048'],
                'number_product' => ['required'],
                'price_product' => ['required'],
               
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
                'content_desc' => 'Chi tiết sản phẩm',
                'status' => 'Trạng thái',
                'slug_product' => 'Link thân thiện',
                'product_thumb' => 'Ảnh đại diện',
                'product_image' => 'Ảnh mô tả',
                'number_product' => 'Số lượng sản phẩm',
                'price_product' => 'Giá sản phẩm',
                

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
        $files=[];
        if ($request->hasFile('product_image')) {
          //  $images = $request->file('product_image');
           
           
            foreach($request->file('product_image') as $image){
               $name = time().rand(1,100).'.'.$image->extension();
              $image-> move('public/uploads',$name);
                $files[] = $name;
            }
            $images_url = json_encode($files);
           
        }
        //return $path;
        
      Product::where('id', $id)->update ([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'content' => $request->input('content'),
            'slug_product' => Str::slug($request->input('slug_product')),
            'price_product' => $request->input('price_product'),
            'number_product' => $request->input('number_product'),
            'featured' => $request->input('featured'),
            'content_desc' => $request->input('content_desc'),
            //'cat_id' => $request->input('parent_cat'),
            'product_thumb' => $thumnail,
            'product_image' => $images_url,
            'discount'=>$request->input('discount_product'),
            'user_id'=>Auth::id(),
        ]);
       
        // $totalfiles = count($_FILES['product_image']['name']);
        // for ($i = 0; $i < $totalfiles; $i++) {
        //     $filename = $_FILES['product_image']['name'][$i];
        //     $imgs = 'public/upload/'.$filename;
        //     if (move_uploaded_file($_FILES["product_image"]["tmp_name"][$i], $imgs)) {
        //         $data=array(
        //             'product_id' =>$insert,
        //             'images'=> $imgs
        //         );
        //         Product::create($data);
        //     }
        // }
        return redirect('admin/products/list')->with('statuss', 'Đã cập nhật sản phẩm thành công!');
    }

    //===================================Danh mục
    function listCat(){
        $list_cat = Product_cat::all();
        //return $list_add_cat;
        $list_cat_multiple = data_tree($list_cat);
        return view('admin/products/cat/list',compact('list_cat_multiple'));
    }

    function addCat(){
        $list_add_cat = Product_cat::all();
       //return $list_add_cat;
       $list_add_cat_multiple = data_tree($list_add_cat);
        return view('admin/products/cat/add',compact('list_add_cat_multiple'))->with('statuss', 'Đã thêm  danh mục sản phẩm thành công!');
    }

    
    function storeCat(Request $request){
      
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'slug_productCat' => ['required', 'string', 'min:5'],
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
                'slug_productCat' => 'Link thân thiện',
                'status' => 'Trạng thái',
                //'parent_cat' => 'Danh mục cha',
                
            ]

        );
        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'parent_cat' => $request->input('parent_cat'),
            
            'slug_productCat' => Str::slug($request->input('slug_productCat')),
            'user_id'=>Auth::id()
        ];
        Product_cat::create($data);
        
        return redirect('admin/products/cat/list')->with('statuss', 'Đã thêm  danh mục mới thành công!');
    }
    function delete_productCat($id)
    {
        $products = Product_cat::find($id);
        $products->delete();
        return redirect('admin/products/cat/list')->with('statuss', 'Đã xóa danh mục thành công!');
    }
    function editCat($id){
        $list_edit_cat = Product_cat::find($id);
       //eturn $source;
       $list_update = Product_cat::all();
       $list_edit_cat_multiple = data_tree($list_update);
        
        return view('admin/products/cat/edit', compact('list_edit_cat_multiple','list_edit_cat'));
    }
    function updateCat(Request $request, $id){
        
        $request->validate(
            [
                'name' => ['required', 'string', 'min:4', 'max:255'],
                'slug_productCat' => ['required', 'string', 'min:5'],
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
                'slug_productCat' => 'Link thân thiện',
                'status' => 'Trạng thái',
                //'parent_cat' => 'Danh mục cha',
                
            ]

        );
        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'parent_cat' => $request->input('parent_cat'),
            
            'slug_productCat' => Str::slug($request->input('slug_productCat')),
            'user_id'=>Auth::id()
        ];
        Product_cat::where('id', $id)->update($data);
        
            
       
        return redirect('admin/products/cat/list')->with('statuss', 'Đã cập nhật bài viết thành công!');
    }
}
