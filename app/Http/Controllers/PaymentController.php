<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function vn_pay(Request $request)
    {
        // dd($request->all());
        Log::info($request->all());
        $userId = $request->input("user_id");
        $chitietietsp_id = $request->input("chitietietsp_id");
        $address = $request->input("address");
        $giaohang = $request->input("giaohang");
        $totalPrice = $request->input("tongtien");
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return', ['user_id' => $userId, 'chitietietsp_id' => $chitietietsp_id, 'address' => $address, 'giaohang' => $giaohang]);
        $vnp_TmnCode = "PIEV8J2S";
        $vnp_HashSecret = "O3AEPIM3G0LHTBLP558JNEA5LHGF2UBT";

        $vnp_TxnRef = $totalPrice;
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "Website";
        $vnp_Amount = $totalPrice * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
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
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', trim($hashdata, '&'), $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->to($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        Log::info('Callback data: ' . json_encode($request->all()));

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        if ($vnp_ResponseCode == '00') {
            $user = Auth::user();
            $address = $request->input("address");
            $chitietietsp_id = $request->input("chitietietsp_id");
            $giaohang = $request->input("giaohang");

            $checkout = Cart::with('productDetail')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($checkout->isEmpty()) {
                return redirect()->route('trang-chu-user')->with('error', 'Giỏ hàng trống!');
            }

            $tong = 0;
            foreach ($checkout as $item) {
                $tong += $item->dongia * $item->soluong;
            }


            $order = Order::create([
                'ma_kh' => $user->id,
                'delivery_address' => $request->address,
                'ngay_lap_hoa_don' => now(),
                'ngay_nhan_hang' => now()->addDays(3),
                'ttthanhtoan' => $tong,
                'ttvanchuyen' => $giaohang,
                'trangthai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'giaohang' => 1,

            ]);

            foreach ($checkout as $item) {

                Order_detail::create([
                    'ma_hd' => $order->id,
                    'sp_id' => $item->product_id,
                    'chitietietsp_id' => $chitietietsp_id,
                    'soluong' => $item->soluong,
                    'giaohang' => 0,
                    'thanhtien' => $item->dongia * $item->soluong,
                    'diachi' => $address,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'size' => $item->size,
                    'color' =>$item->color,
                ]);


                   // Cập nhật số lượng sản phẩm chính
            $product = Product::find($item->product_id);
            if ($product) {
                $product->soluong -= $item->soluong;
                $product->save();
            } else {
                return redirect()->back()->withErrors(['product' => 'Không tìm thấy sản phẩm với ID đã chọn.']);
            }

            // Kiểm tra và cập nhật số lượng chi tiết sản phẩm (size và màu)
            $productdetail = Product_detail::where('sanpham_id', $item->product_id)
                ->where('size_id', $item->size)
                ->where('mau_id', $item->color)
                ->first();

            if ($productdetail) {
                $productdetail->soluong -= $item->soluong;
                $productdetail->save();

                if ($productdetail->soluong == 0) {
                    $productdetail->trangthai = 1;
                    $productdetail->save();
                }
            } else {
                return redirect()->back()->withErrors(['product' => 'Không tìm thấy chi tiết sản phẩm với các thông tin đã chọn.']);
            }
        }

            Cart::where('user_id', $user->id)->delete();
            return redirect()->route('trang-chu-user')->with('success', 'Thanh toán thành công!');
        } else {
            return redirect()->route('payment.failure');
        }
    }

    public function paymentFailure()
    {
        return view('payment.failure');
    }
}
