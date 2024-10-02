<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    function list(){
        $blogs=Post::paginate(5);
        $top_product=Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $banners = Banner::all();
        
        return view('client/blog',compact('blogs','top_product','banners'));
    }
    function detail_blog($id){
        $blogs=Post::find($id);
        $top_product=Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $banners = Banner::all();
        
        return view('client/detail_blog',compact('blogs','top_product','banners'));
    }
}
