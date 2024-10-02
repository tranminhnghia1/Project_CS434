<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Product_cat;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    //
    function list(Request $request){
        $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
        $featured_product = Product::inRandomOrder()-> where('status', '=', 'posted')->take(6)->get();
        $discount_product = Product::where('status', '=', 'posted')->where('discount','!=','0')->get();
        $sliders = Slider::all();
        $banners = Banner::all();
        $latest_product = Product::where('status', '=', 'posted')->latest()->take(8)->get();
        $top_product=Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $products = Product::where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        $category = Product_cat::where('status', '=', 'posted')->get();
        return view('client/home',compact('featured_product','discount_product','sliders','latest_product','top_product','banners','category'));
    }
    function category_product(){
        $category = Product_cat::where('status', '=', 'posted')->get();
        return view('client/components/sidebar-productCat',compact('category'));
        
    }
    
    function loginClient(){
        return view('auth.login');
    }
    function logoutClient(){
        return view('client/logoutClient');
    }

    function registerClient()
    {
        
        return view('client/registerClient');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:8', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => 'required|string|min:8','confirmed'
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
                'password' => 'Mật khẩu'
            ]

        );
       $user =  User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),

        ]);
      
        return redirect('admin/users/list')->with('status', 'Đã thêm thành viên thành công!');
    }
}
