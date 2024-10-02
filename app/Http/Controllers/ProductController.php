<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_cat;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function searchChildren($data, $id, &$child)
    {
        foreach ($data as $item) {
            if ($item['parent_cat'] == $id) {
                $child[] = $item['id'];
                $this->searchChildren($data, $item['id'], $child);
            }
        }
    }

    function list(Request $request, $slug_productCat)
    {
        $keyword = $request->query('keyword', ''); // giá trị mặc định là chuỗi rỗng nếu không có giá trị được gửi đến
        // $keyword = "";
        //     if ($request->input('keyword')) {
        //         $keyword = $request->input('keyword');
        //     }
        // $products = Product::where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        $count_product_total = Product::count();
        $category = Product_cat::where('status', '=', 'posted')->get();

        /////////=========
        $product_cat = Product_cat::where('slug_productCat', $slug_productCat)->first();
        $this_cat_id = $product_cat->id;
        $data = Product_cat::all();
        $child[] = $this_cat_id;
        $this_cat_name = $product_cat->name;
        $this->searchChildren($data, $this_cat_id, $child);
        $products = Product::whereIn('cat_id', $child)->where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        return view('client/product', compact('products', 'count_product_total', 'category','this_cat_name'));
        // $products = Product::all();
        // $ar =[
        //     'status' => true,
        //     'message' =>"Danh sách sản phẩm"
            
        // ];
        // return response()->json($arr, 200);
    }
    function litsProduct(Request $request){
        $keyword = $request->query('keyword', ''); // giá trị mặc định là chuỗi rỗng nếu không có giá trị được gửi đến
        // $keyword = "";
        //     if ($request->input('keyword')) {
        //         $keyword = $request->input('keyword');
        //     }
        // $products = Product::where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        $count_product_total = Product::count();
        $category = Product_cat::where('status', '=', 'posted')->get();

        /////////=========
     
         $this_cat_name = ' ';
        
        $products = Product::where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        return view('client/product', compact('products', 'count_product_total', 'category','this_cat_name'));
    }

    function category_product(Request $request)
    {
        $category = Product_cat::where('status', '=', 'posted')->get();
        return view('client.components.sidebar-productCat', compact('category'));
    }

    function detailProduct($id)
    {
        $detail_product = Product::find($id);
        $data = Product::find($id)->product_image;
        //return ($data);
        $productImage =  json_decode($data, true);
        $top_product = Product::where('status', '=', 'posted')->latest()->take(6)->get();
        $category = Product_cat::where('status', '=', 'posted')->get();
       // $sameCategory= Product::where('status', '=', 'posted')->where('id', '=', $id)->take(6)->get();
        //$sameCategory_product = $sameCategory;
        //sản phẩm cùng chuyên mục
        $sameCategory = Product::where('cat_id', $detail_product->cat_id)       
        ->where('id', '<>', $detail_product->id)//  <> để lấy cùng chuyển mục nhưng trừ thằng hiện tại này ra
        ->take(6)->get();
        
        //echo("prev")
        //print_r($productImage) ;
        $this_cat_name = ' ';

        // rewview
        
        $reviews = Review::where('product_id', $id)->latest()->get();
        
        return view('client/detail_product', compact('detail_product', 'productImage', 'top_product','category','sameCategory','this_cat_name','reviews'));
    }
    function filter(Request $request)
    {
        $products = Product::query();
        $count_product_total = Product::count();
        $category = Product_cat::where('status', '=', 'posted')->get();

        if ($request->has('select')) {
            switch ($request->input('select')) {
                case '1':
                    $products->orderBy('name');

                    break;
                case '2':
                    $products->orderByDesc('name');
                    break;
                case '3':
                    $products->orderByDesc('price_product');
                    break;
                case '4':
                    $products->orderBy('price_product');
                    break;
            }
        }
        $productCount = $products->count();
        $products = $products->paginate(12);
        $this_cat_name = ' ';


        return view('client/product', compact('products', 'productCount', 'count_product_total', 'category','this_cat_name'));
    }
    function price(Request $request)
    {
        $category = Product_cat::where('status', '=', 'posted')->get();

        $products = Product::query();
        $count_product_total = Product::count();

        $priceRange = $request->input('r-price');

        switch ($priceRange) {
            case '0':
                break;
            case '1':
                $products->where('price_product', '<', 500000);
                break;
            case '2':
                $products->whereBetween('price_product', [500000, 1000000]);
                break;
            case '3':
                $products->whereBetween('price_product', [1000000, 5000000]);
                break;
            case '4':
                $products->whereBetween('price_product', [5000000, 10000000]);
                break;
            case '5':
                $products->where('price_product', '>', 10000000);
                break;
        }
        $products = $products->paginate(12);
        $this_cat_name = ' ';
        return view('client/product', compact('products', 'count_product_total','category','this_cat_name'));
    }
    function search(Request $request)
    {
        $count_product_total = Product::count();
        $category = Product_cat::where('status', '=', 'posted')->get();

        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $this_cat_name = ' ';
        $products = Product::where('status', '=', 'posted')->where('name', 'LIKE', "%{$keyword}%")->paginate(12);
        return view('client/product', compact('products', 'count_product_total', 'category','this_cat_name'));
    }

    //review
    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review_text' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }
}
