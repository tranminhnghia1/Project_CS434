<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Info_order;
class DashboardController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show()
    {
        $count_user_poster = Info_order::where('status', '=', 'success')->count();
        $count_user_waiting = Info_order::where('status', '=', 'waiting')->count();
        $count_user_pending = Info_order::where('status', '=', 'pending')->count();
        $count_user_cancel = Info_order::where('status', '=', 'dustin')->count();
        $total_product = Info_order::select('num_order')->sum('num_order');
        ///tổng doanh số sp
        $sales = Info_order::get();
    
        // Lặp qua tất cả các bản ghi và tính tổng doanh số
        // foreach ($sales as $sale) {
        //     // Chuyển đổi giá trị doanh số bằng cách thay thế dấu chấm bằng dấu trống
        //     $total_price = str_replace('.', '', $sale->total_price);
        //     // Tính tổng doanh số
        //     $total_sales += $total_price;
        // }

        // In ra tổng doanh số
        

        $count = [$count_user_poster, $count_user_waiting, $count_user_pending, $count_user_cancel];
        $list_order = Info_order::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.dashboard', compact('list_order', 'count', 'total_product'));
    }
}
