<?php

namespace App\Http\Controllers;

use App\Models\Info_order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'success' => 'Thành công',
            'waiting' => 'Đang vận chuyển',
            'pending' => 'Chờ xử lí',
            'dustin' => 'Hủy đơn'
        ];
        if ($status == 'success' || $status == 'waiting' || $status == 'dustin' || $status == 'pending') {
            if ($status == 'success') {
                $list_act = [

                    'waiting' => 'Đang vận chuyển',
                    'pending' => 'Chờ xử lí',
                    'dustin' => 'Hủy đơn'
                ];
                $orders = Info_order::where('status', '=', 'success')->paginate(5);
            }
            if ($status == 'waiting') {
                $list_act = [

                    'success' => 'Thành công',

                    'pending' => 'Chờ xử lí',
                    'dustin' => 'Hủy đơn'
                ];
                $orders = Info_order::where('status', '=', 'waiting')->paginate(10);
            }
            if ($status == 'pending') {
                $list_act = [
                    'success' => 'Thành công',
                    'waiting' => 'Đang vận chuyển',

                    'dustin' => 'Hủy đơn'
                ];
                $orders = Info_order::where('status', '=', 'pending')->paginate(10);
            }
            if ($status == 'dustin') {
                $list_act = [

                    'success' => 'Thành công',
                    'waiting' => 'Đang vận chuyển',
                    'pending' => 'Chờ xử lí',

                ];
                $orders = Info_order::where('status', '=', 'dustin')->paginate(10);
            }
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $orders = Info_order::where('fullname', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(5);
        }
        $count_user_active = Info_order::all()->count();
        $count_user_poster = Info_order::where('status', '=', 'success')->count();
        $count_user_waiting = Info_order::where('status', '=', 'waiting')->count();
        $count_user_pending = Info_order::where('status', '=', 'pending')->count();
        $count_user_cancel = Info_order::where('status', '=', 'dustin')->count();
        $total_product = Info_order::select('num_order')->sum('num_order');
        $count = [$count_user_active, $count_user_poster, $count_user_waiting, $count_user_pending, $count_user_cancel];
        // $list_order=Info_order::all();

        //tổng doanh số sp
        $sales = Info_order::get();

        $total_sales = 0;
        // Lặp qua tất cả các bản ghi và tính tổng doanh số
        foreach ($sales as $sale) {
            // Chuyển đổi giá trị doanh số bằng cách thay thế dấu chấm bằng dấu trống
            $total_price = str_replace('.', '', $sale->total_price);
            // Tính tổng doanh số
            $total_sales += $total_price;
        }
        return view('admin.orders.list', compact('orders', 'count', 'list_act','total_product','total_sales'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check) {


            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'success') {
                    Info_order::where('id', $list_check)
                        ->update([
                            'status' => 'success'

                        ]);
                    return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }

                if ($act == 'waiting') {
                    Info_order::where('id', $list_check)
                        ->update([
                            'status' => 'waiting'

                        ]);
                    return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                if ($act == 'pending') {
                    Info_order::where('id', $list_check)
                        ->update([
                            'status' => 'pending'

                        ]);
                    return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
                if ($act == 'dustin') {
                    Info_order::where('id', $list_check)
                        ->update([
                            'status' => 'dustin'

                        ]);
                    return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
                }
            }
        } else {
            return redirect('admin/orders/list')->with('statuss', 'Bạn cần chọn phần tử để thực thi');
        }
    }

    function edit(Request $request, $id)
    {
        $list_act = [
            'success' => 'Thành công',
            'waiting' => 'Đang vận chuyển',
            'pending' => 'Chờ xử lí',
            'dustin' => 'Hủy đơn'
        ];
        $act = $request->input('act');
        if ($act == 'success') {
            Info_order::where('id', $id)
                ->update([
                    'status' => 'success'

                ]);
                return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
        }

        if ($act == 'waiting') {
            Info_order::where('id', $id)
                ->update([
                    'status' => 'waiting'

                ]);
                return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
        }
        if ($act == 'pending') {
            Info_order::where('id', $id)
                ->update([
                    'status' => 'pending'

                ]);
                return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
        }
        if ($act == 'dustin') {
            Info_order::where('id', $id)
                ->update([
                    'status' => 'dustin'

                ]);
                return redirect('admin/orders/list')->with('statuss', 'Bạn đã cập nhật  thành công');
        }

        $list_order = Info_order::find($id);
        $detail_order = Info_order::find($id)->info_cart;
        $detail_products =  json_decode($detail_order, true);
        //dd($detail_products);
        return view('admin.orders.edit', compact('detail_products', 'list_order','list_act'));
    }
    function delete_order($id)
    {
        $products = Info_order::find($id);
        $products->delete();
        return redirect('admin/orders/list')->with('statuss', 'Đã xóa đơn hàng thành công!');
    }
}
