<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Info_order;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Stringable;

class CartController extends Controller
{
    //
    function list()
    {
        return view('client/showCart');
    }
    function add(Request $request, $id)
    {
        // Cart::destroy(); //để reset giỏ hàng

        $products = Product::find($id);
        //return $products;
        $qty = $request->input('num');
        if ($request->input('num')) {
            $qty = $request->input('num');
        } else {
            $qty = 1;
        }
        //dd($qty);

        Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'qty' => $qty,
            'price' => $products->price_product,
            'options' => ['thumnail' => $products->product_thumb]
        ]);

        // return redirect('gio-hang.html');
        return response()->json([
            'success' => true,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công'
        ]);
       
    }
    function add_cart_detail(Request $request, $id)
    {
        // Cart::destroy(); //để reset giỏ hàng

        $products = Product::find($id);
        //return $products;
        $qty = $request->input('num');
        if ($request->input('num')) {
            $qty = $request->input('num');
        } else {
            $qty = 1;
        }
        //dd($qty);

        Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'qty' => $qty,
            'price' => $products->price_product,
            'options' => ['thumnail' => $products->product_thumb]
        ]);

         return redirect('gio-hang.html');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Thêm sản phẩm vào giỏ hàng thành công'
        // ]);
       
    }
    # them sp ajax
    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        Cart::add(
            [
                'id' => $data['id'],
                'name' => $data['name'],
                'price' => $data['price_product'],
                'qty' => 1,
                'options' => [
                    'thumnail' => $data['product_thumb']
                ],
            ]
        );
    }

    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect('gio-hang.html');
    }

    function destroy()
    {
        Cart::destroy();
        return redirect('gio-hang.html');
    }
    function update(Request $request)
    {

        $data = $request->get('qty');
        foreach ($data as $k => $v) {
            Cart::update($k, $v);
        }
        return redirect('gio-hang.html');
    }

    //update cart ajax
    function ajax_shopping_cart(Request $request)
    {
        $qty = $request->qty;
        $id = $request->id;
        //return $qty;
        Cart::update($id, $qty);

        foreach (Cart::content() as $row) {
            if ($row->rowId == $id) {
                $sub_total = $row->total;
            }
        }
        $sub_total = number_format($sub_total, 0, '', '.') . "đ";

        $data = array(
            'sub_total' => $sub_total,
            'total_price' => Cart::total(),
            'num' => Cart::count()
        );
        return json_encode($data);
    }

    //thông tin thanh toán
    function checkout()
    {
        $provinces = Province::orderBy('name')->orderBy('name')->get();
        $districts = District::orderBy('name')->orderBy('name')->get();
        $wards = Ward::orderBy('name')->orderBy('name')->get();

        return view('client/checkout', compact('provinces', 'districts', 'wards'));
    }
    ///địa chỉ bằng jjax

    public function getDistricts($province_id)
    {
        echo json_encode(District::where('province_id', $province_id)->orderBy('name')->get());
    }

    public function getWards($district_id)
    {
        echo json_encode(Ward::where('district_id', $district_id)->orderBy('name')->get());
    }
    //mua hàng thành công
    function thankyou(Request $request)
    {
        $request->validate(
            [
                'fullname' => ['required', 'string', 'min:4', 'max:255'],
                'address' => ['required', 'string', 'min:5'],
                'phone_number' => ['required', 'string', 'min:10', 'max:12'],
                'province' => ['required'],
                'district' => ['required'],
                'ward' => ['required'],
                'email' => ['required'],
                'payment' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'status' => ':attribute không được để trống'
            ],
            [
                'fullname' => 'Tên khách hàng',
                'address' => 'Địa chỉ',
                'province' => 'Tỉnh',
                'district' => 'Huyện',
                'ward' => 'Xã',
                'email' => 'Email',
                'phone_number' => 'Số diện thoại',
                'payment' => 'Phương thức thanh toán'
            ]

        );
        $info_cart = json_encode(Cart::content());
        //return $info_cart;
        $cart = Cart::content();
        $total_price = Cart::total();
        $total_price_float = (float) str_replace(',', '', $total_price); // Chuyển đổi thành số thực

        $total_price_formatted = number_format($total_price_float, 0, ',', '.'); // Định dạng số nguyên với dấu phân cách là dấu chấm

        $qty = Cart::content()->sum('qty');
        ///=========
        // $inf->province_id = $request->input('province');
        // $province = Info_order::find($request->input('province'));
        // $product->province_name = $province ? $province->name : '';
        $data = [
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'province' => $request->input('province_name'),
            'district' => $request->input('district_name'),
            'phone_number' => $request->input('phone_number'),
            'ward' => $request->input('ward_name'),
            'email' => $request->input('email'),
            'note' => $request->input('note'),
            'info_cart' => $info_cart,
            'total_price' => $total_price_formatted,
            'num_order' => $qty,
            'order_code' => "NGHIA#" . time(),
            'payment' => $request->input('payment')
        ];
        $data['order'] = $cart;
        $data['total'] = Cart::total();
        //$data['fullname'] = $request->input('fullname');
        Info_order::create($data);

        // trừ số lương sp trong kho khi kh đã mua
        // Cập nhật số lượng sản phẩm trong bảng products
        foreach ($cart as $item) {
            $product = Product::find($item->id);
            if ($product) {
                $product->number_product -= $item->qty;
                $product->save();
            }
        }
        //Send Mail
        $data['fullname'] = $request->input('fullname');
        $data['address'] = $request->input('address');
        $data['province'] = $request->input('province_name');
        $data['district'] = $request->input('district_name');
        $data['ward'] = $request->input('ward_name');
        $data['order_code'] = "NGHIA#" . time();
        $data['phone_number'] = $request->input('phone_number');
        $data['email'] = $request->input('email');
        $emailCustomer = $request->input('email');
        $nameCustomer = $request->input('fullname');
        Mail::send('mails.send', $data, function ($message) use ($emailCustomer, $nameCustomer) {
            $message->from('minhnghia101022@gmail.com', 'UNIMART STORE');
            $message->to($emailCustomer, $nameCustomer);
            $message->subject('[UNIMART STORE] Xác Nhận Đơn Hàng Ở Cửa Hàng UNIMART');
        });
        // Xóa giỏ hàng sau khi đặt hàng thành công
        Cart::destroy();

        // Lưu thông tin đơn hàng vào session (nếu cần thiết)
        $request->session()->put('data', $data);

        return view('client/thankyou', compact('data'));
    }

    //payment vnp
    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_Returnurl = config('vnpay.vnp_Returnurl');
        $vnp_TxnRef = date("YmdHis"); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';

        //
        $totalPaymentString = str_replace(['đ', '.', ','], '', $data['payment']);

                // Chuyển đổi thành số thực
                $totalPaymentNumber = floatval($totalPaymentString);
        
                // Thực hiện phép tính
                $vnp_Amount = $totalPaymentNumber * 100;
               // $vnp_Amount = $data['totalpayment'] * 100;
        
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_BankCode" => $vnp_BankCode
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->get('vnp_SecureHash');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . $key . "=" . $value;
            } else {
                $hashData .= $key . "=" . $value;
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            // Xử lý đơn hàng tại đây
            return response()->json(['message' => 'Giao dịch thành công!']);
        } else {
            return response()->json(['message' => 'Giao dịch không thành công!']);
        }
    }
}
