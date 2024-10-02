<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
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
        $totalPaymentString = str_replace(['đ', '.', ','], '', $data['totalpayment']);

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

//     public function vnpay_payment(Request $request)
//     {
//         $data = $request->all();
//         session(['cost_id' => $request->id]);
//         session(['url_prev' => url()->previous()]);
//         $vnp_TmnCode = "ZNJZT1U6"; //Mã website tại VNPAY 
//         $vnp_HashSecret = "V8XWXUDUAV4F00DMSLBRAOICXTB9Z82M"; //Chuỗi bí mật
//         $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//         $vnp_Returnurl = "http://localhost:8000/return-vnpay";
//         $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
//         $vnp_OrderInfo = "Thanh toán hóa đơn phí sản phẩm";
//         $vnp_OrderType = 'billpayment';
//         //======
//         $totalPaymentString = str_replace(['đ', '.', ','], '', $data['totalpayment']);

//         // Chuyển đổi thành số thực
//         $totalPaymentNumber = floatval($totalPaymentString);

//         // Thực hiện phép tính
//         $vnp_Amount = $totalPaymentNumber * 100;
//        // $vnp_Amount = $data['totalpayment'] * 100;
//         $vnp_Locale = 'vn';
//         $vnp_IpAddr = request()->ip();

//         $inputData = array(
//             "vnp_Version" => "2.0.0",
//             "vnp_TmnCode" => $vnp_TmnCode,
//             "vnp_Amount" => $vnp_Amount,
//             "vnp_Command" => "pay",
//             "vnp_CreateDate" => date('YmdHis'),
//             "vnp_CurrCode" => "VND",
//             "vnp_IpAddr" => $vnp_IpAddr,
//             "vnp_Locale" => $vnp_Locale,
//             "vnp_OrderInfo" => $vnp_OrderInfo,
//             "vnp_OrderType" => $vnp_OrderType,
//             "vnp_ReturnUrl" => $vnp_Returnurl,
//             "vnp_TxnRef" => $vnp_TxnRef,
//         );

//         if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//             $inputData['vnp_BankCode'] = $vnp_BankCode;
//         }
//         ksort($inputData);
//         $query = "";
//         $i = 0;
//         $hashdata = "";
//         foreach ($inputData as $key => $value) {
//             if ($i == 1) {
//                 $hashdata .= '&' . $key . "=" . $value;
//             } else {
//                 $hashdata .= $key . "=" . $value;
//                 $i = 1;
//             }
//             $query .= urlencode($key) . "=" . urlencode($value) . '&';
//         }

//         $vnp_Url = $vnp_Url . "?" . $query;
//         if (isset($vnp_HashSecret)) {
//            // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
//             $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
//             $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
//         }
//         return redirect($vnp_Url);
//     }

//     public function return(Request $request)
// {
//     $url = session('url_prev','/');
//     if($request->vnp_ResponseCode == "00") {
//         $this->apSer->thanhtoanonline(session('cost_id'));
//         return redirect($url)->with('success' ,'Đã thanh toán phí dịch vụ');
//     }
//     session()->forget('url_prev');
//     return redirect($url)->with('errors' ,'Lỗi trong quá trình thanh toán phí dịch vụ');
// }

}
