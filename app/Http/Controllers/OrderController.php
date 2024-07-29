<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Order_status;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Import Session

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Lấy các mục trong giỏ hàng của người dùng từ bảng giỏ hàng (cart)
            $cartItems = Cart::where('user_id', $user->id)->get();

            // Tính toán tổng số tiền
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->product->price * $item->quantity; // Giả sử product là relation đến bảng sản phẩm
            }
            $shippingFee = 0;
            $total = $subtotal + $shippingFee;

            // Lấy danh sách các đơn hàng liên quan đến người dùng
            $orders = Order::where('ma_kh', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.checkout', compact('orders', 'cartItems', 'subtotal', 'total'));
        } else {
            return redirect()->route('auth');
        }
    }
    // Phương thức để xử lý mua hàng
    public function buy(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
        //dd($request->all());
        // Lấy thông tin sản phẩm từ request
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id');
        $colorId = $request->input('mau_id');
        $quantity = $request->input('soluong');

        // Tìm sản phẩm trong cơ sở dữ liệu
        $product = Product::find($productId);
        if (!$product) {
            alert()->error('Lỗi', 'Không tìm thấy sản phẩm.');
            return redirect()->back();
        }

        // Tìm chi tiết sản phẩm dựa trên sản phẩm, màu sắc và kích thước
        $productDetail = Product_detail::where('sanpham_id', $productId)
            ->where('size_id', $sizeId)
            ->where('mau_id', $colorId)
            ->first();

        if (!$productDetail || $productDetail->soluong < $quantity) {
            alert()->error('Lỗi', 'Sản phẩm đã hết hàng hoặc không đủ số lượng.');
            return redirect()->back();
        }

        // Thêm vào giỏ hàng (lưu vào session)
        $cartItems = Session::get('cart', []);

        // Tạo một mục mới cho giỏ hàng
        $cartItem = [
            'product_id' => $productId,
            'product_name' => $product->ten_sp,
            'size_id' => $sizeId,
            'color_id' => $colorId,
            'quantity' => $quantity,
            'price' => $product->dongia,
        ];

        // Thêm vào giỏ hàng
        $cartItems[] = $cartItem;

        // Lưu lại giỏ hàng vào session
        Session::put('cart', $cartItems);

        // Thông báo thành công và chuyển hướng về trang chủ hoặc giỏ hàng
        alert()->success('Thành công', 'Đã thêm sản phẩm vào giỏ hàng.');
        return redirect()->route('trang-chu');
    }

    public function show($id)
    {
        $order = Order_detail::with('product', 'order', 'order.orderstatus', 'productDetail.firstImage', 'productDetail.size','productDetail.color')->where('ma_hd', $id)->get(); // Replace with your actual model and relationships

           foreach ($order as $item) {
                $firstImage = $item->productDetail->firstImage;
            }

        // dd($images);
        return view('admin.chinh-sua-don-hang', compact('order'));
    }

    public function update(Request $request, $id)
    {
        // Find Order_detail by ma_hd
        $orderDetail = Order_detail::where('ma_hd', $id)->first();
        if (!$orderDetail) {
            return redirect()->route('admin.don-hang')->with('error', 'Không tìm thấy đơn hàng.');
        }
        $order = Order::find($orderDetail->ma_hd);
        // Update the status of the Order
        $order->trangthai = 2; // Change status to 2
        $order->save();
        return redirect()->route('quan-li-don-hang')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }


   public function getorder(Request $request)
    {
        $query = Order::with('orderdetail.product', 'khachangorder', 'orderstatus');

        if ($request->has('status') && $request->status != '') {
            $query->where('trangthai', $request->status);
        }

        if ($request->has('payment') && $request->payment != '') {
            $query->where('ttvanchuyen', $request->payment);
        }

        // Lọc theo ngày
        if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->paginate(10); // Hiển thị 10 đơn hàng mỗi trang

        $orderStatuses = Order_status::all();

        return view('admin.quan-li-don-hang', compact('orders', 'orderStatuses'));
    }
    public function exportPDF()
    {
        $orders = Order::with('orderdetail.product', 'khachangorder', 'orderstatus')->get();
        $pdf = PDF::loadView('pdf.invoice', compact('orders'));
        return $pdf->download('danh_sach_don_hang.pdf');
    }

    public function exportPDFdetail($id)
    {
         $order = Order_detail::with('product', 'order', 'order.orderstatus', 'productDetail.firstImage', 'productDetail.size','productDetail.color')->where('ma_hd', $id)->get(); // Replace with your actual model and relationships

           foreach ($order as $item) {
                $firstImage = $item->productDetail->firstImage;
            }
        $pdf = PDF::loadView('pdf.don-hang-chi-tiet', compact('order'));
        return $pdf->download('Chi tiet hoa don.pdf');
    }
    public function countTotalDate()
    {
        $total = Order::whereDate('created_at', Carbon::today())
            ->sum('ttthanhtoan');
        return view('admin.doanh-thu', compact('total'));
    }
}
