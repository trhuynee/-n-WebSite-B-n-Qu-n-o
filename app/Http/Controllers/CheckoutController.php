<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $user = Auth::user();
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id');
        $colorId = $request->input('mau_id');
        $quantity = $request->input('soluong');

        $productDetail = Product_detail::where('sanpham_id', $productId)
            ->where('size_id', $sizeId)
            ->where('mau_id', $colorId)
            ->first();

        if (!$productDetail) {
            return redirect()->back()->withErrors(['product' => 'Không tìm thấy chi tiết sản phẩm']);
        }

        $discountPercent = $productDetail->product->giamgia;
        $price = $productDetail->product->dongia;
        $discountedPrice = $discountPercent > 0 ? $price - ($price * $discountPercent / 100) : $price;
        $subtotal = $discountedPrice * $quantity;
        $phigiaohang = $subtotal >= 299999 ? 0 : 19000;
        $total = $subtotal + $phigiaohang;

        // Hiển thị trang thanh toán với thông tin sản phẩm và tổng giá
        return view('user.checkout', compact('subtotal', 'total', 'phigiaohang', 'productDetail', 'quantity', 'discountedPrice', 'user'));
    }


    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $user = Auth::user();
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id') ?? 1;
        $colorId = $request->input('mau_id') ?? 1;
        $quantity = $request->input('soluong');
        $productDetail = Product_detail::where('sanpham_id', $productId)
            ->where('size_id', $sizeId)
            ->where('mau_id', $colorId)
            ->first();
        if (!$productDetail) {
            return redirect()->back()->withErrors(['product' => 'Không tìm thấy chi tiết sản phẩm']);
        }

        $discountPercent = $productDetail->product->giamgia;
        $price = $productDetail->product->dongia;
        $discountedPrice = $discountPercent > 0 ? $price - ($price * $discountPercent / 100) : $price;
        $subtotal = $discountedPrice * $quantity;
        $phigiaohang = $subtotal >= 299999 ? 0 : 19000;
        $total = $subtotal + $phigiaohang;



        $order = new Order();
        $order->ma_kh = $user->id;
        $order->ttthanhtoan = 1;
        $order->ttvanchuyen = 1;
        $order->trangthai = 1;
        $order->save();

        $orderDetail = new order_detail();
        $orderDetail->ma_hd = $order->id;
        $orderDetail->sp_id = $productId;
        $orderDetail->chitietietsp_id = $productDetail->id;
        $orderDetail->soluong = $quantity;
        $orderDetail->giaohang = $phigiaohang;
        $orderDetail->thanhtien = $total;
        $orderDetail->diachi = $user->diachi;
        $orderDetail->save();

        // Cập nhật số lượng sản phẩm
        $productDetail->update(['soluong' => $productDetail->soluong - $quantity]);

        // Xuất thông báo đặt hàng thành công
        alert()->success('Thành công', 'Đặt hàng thành công');
        return redirect()->back();
    }


}
