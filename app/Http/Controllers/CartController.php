<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Image;
use App\Models\Order;
use App\Models\Order_detail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $giohang = Cart::with('productDetail', 'productDetail.firstImage')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
            $tong = 0;

            foreach ($giohang as $item) {
                $item['isPayment'] = false;
                $tong += $item->dongia * $item->soluong;
                $firstImage = $item->productDetail->firstImage;
                Log::info($item);
            }

            Log::info($giohang->pluck('productDetail.sanpham_id'));
            // Retrieve images related to product details in the cart
            // dd($giohang);

            return view('user.cart', compact('giohang', 'tong'));
        } else {
            return redirect()->route('auth');
        }
    }

    public function add(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Lấy thông tin sản phẩm từ request
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id');
        $colorId = $request->input('mau_id');
        $quantity = $request->input('soluong');

        Log::info($sizeId);

        // Tìm sản phẩm trong cơ sở dữ liệu
        $product = Product::find($productId);
        if (!$product) {
            alert()->error('Lỗi', 'Không tìm thấy sản phẩm.');
            return redirect()->back();
        }

        // Tìm chi tiết sản phẩm dựa trên sản phẩm, màu sắc và kích thước
        $productDetail = Product_detail::where('sanpham_id', $productId)
            ->where('mau_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();

        if (!$productDetail) {
            alert()->error('Lỗi', 'Không tìm thấy chi tiết sản phẩm với các thông tin đã chọn.');
            return redirect()->back();
        }

        if ($quantity > $productDetail->soluong) {
            alert()->error('Lỗi', 'Sản phẩm không đủ số lượng. Vui lòng chọn lại.');
            return redirect()->back();
        }

        // Tính giá cuối cùng của sản phẩm sau khi áp dụng giảm giá (nếu có)
        $discount = $product->giamgia;
        $price = $product->dongia;
        $discountAmount = ($price * $discount) / 100;
        $finalPrice = $price - $discountAmount;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng hay chưa
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_detail_id', $productDetail->id)
            ->first();

        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
            $cartItem->soluong += $quantity;
            $cartItem->save();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $productId;
            $cart->product_detail_id = $productDetail->id;
            $cart->color = $colorId;
            $cart->size = $sizeId;
            $cart->soluong = $quantity;
            $cart->soluongconlai = $productDetail->soluong;
            $cart->dongia = $finalPrice;
            $cart->save();
        }

        // Hiển thị thông báo thành công và redirect về trang trước
        alert()->success('Thành công', 'Sản phẩm đã được thêm vào giỏ hàng');
        return redirect()->back();
    }

    public function destroy($id)
    {
        // Tìm sản phẩm trong giỏ hàng theo ID và xóa nó
        $cart = Cart::findOrFail($id);
        $cart->delete();
        alert()->success('Thành công', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        return redirect()->route('gio-hang');
    }

    public function update(Request $request, $id)
    {
        // Tìm và cập nhật số lượng sản phẩm trong giỏ hàng
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->soluong = $request->input('soluong');
            $cartItem->save();

            return response()->json([
                'success' => true,
                'total' => $cartItem->dongia * $cartItem->soluong,
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    public function checkout()
    {
        $user = Auth::user();
        if ($user) {
            $checkout = Cart::with('user', 'productDetail', 'product', 'color', 'size', 'productDetail.firstImage')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $tong = 0;

            foreach ($checkout as $item) {
                $tong += $item->dongia * $item->soluong;
                $firstImage = $item->productDetail->firstImage;
            }

            // Lấy danh sách các sp_id từ productDetail
            $productDetailIds = $checkout->pluck('productDetail.sanpham_id')->toArray();

            // Lấy danh sách hình ảnh sản phẩm dựa trên sp_id
            $images = Image::whereIn('sp_id', $productDetailIds)->get();

            return view('user.checkout', compact('checkout', 'tong', 'images'));
        }

        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();
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
            'delivery_address' => $request->diachi,
            'ngay_lap_hoa_don' => now(),
            'ngay_nhan_hang' => now()->addDays(3),
            'ttthanhtoan' => $tong,
            'ttvanchuyen' => $request->giaohang,
            'trangthai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'giaohang' => 0,
        ]);

        foreach ($checkout as $item) {
            $orderDetail = Order_detail::create([
                'ma_hd' => $order->id,
                'sp_id' => $item->product_id,
                'chitietietsp_id' => $item->product_detail_id,
                'soluong' => $item->soluong,
                'giaohang' => 0,
                'thanhtien' => $item->dongia * $item->soluong,
                'diachi' => $request->diachi,
                'created_at' => now(),
                'updated_at' => now(),
                'size' => $item->size,
                'color' => $item->color,
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

        // Xóa giỏ hàng sau khi tạo đơn hàng
        Cart::where('user_id', $user->id)->delete();
        Alert()->success('Thành công', 'Đặt hàng thành công!');
        return redirect()->route('trang-chu-user');
    }
}
