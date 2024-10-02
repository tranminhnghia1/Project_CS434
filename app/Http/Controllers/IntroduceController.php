<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class IntroduceController extends Controller
{
    //
    function list(){
        $pages = Page::find(1);
        $top_product=Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $banners = Banner::all();
        
        return view('client/introduce',compact('pages','top_product','banners'));
    }
    function contact(){
        $pages = Page::find(2);
        $top_product=Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $banners = Banner::all();
        
        return view('client/contact',compact('pages','top_product','banners'));
    }

}
