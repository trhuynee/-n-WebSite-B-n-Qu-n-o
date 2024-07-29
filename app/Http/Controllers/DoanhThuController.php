<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Cart;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Import Session
use PDF;


class DoanhThuController extends Controller
{

    public function index(Request $request)
    {
        $totalSanPham = Product::count();
        $SanPhamDaHet = Product_detail::where('trangthai', 1)->count();
        $query = Order::query();

        $totalThuNhap = $query->sum('ttthanhtoan'); // Tổng thu nhập từ tất cả đơn hàng
        $totalDonHang = $query->count();// Tổng số đơn hàng








        if ($request->has('ngay')) {
            $ngay = Carbon::parse($request->ngay)->format('Y-m-d');
            $totalDonHang = $query->whereDate('ngay_lap_hoa_don', $ngay)->count();
            $totalThuNhap = $query->whereDate('ngay_lap_hoa_don', $ngay)->sum('ttthanhtoan');
            $tongDonHang = $query->with('khachangorder', 'orderdetail.product.category')
                ->whereDate('ngay_lap_hoa_don', $ngay)
                ->get();
            $totalSanPhamDaHet = Product_detail::with('product', 'firstImage', 'product.brand','color','size')->where('trangthai', 1)

                ->get();
        } else {
            $ngayHienTai = Carbon::today()->format('Y-m-d');
            $totalDonHang = $query->whereDate('ngay_lap_hoa_don', $ngayHienTai)->count();
            $totalThuNhap = $query->whereDate('ngay_lap_hoa_don', $ngayHienTai)->sum('ttthanhtoan');
            $tongDonHang = $query->with('khachangorder', 'orderdetail.product.category')
                ->whereDate('ngay_lap_hoa_don', $ngayHienTai)
                ->get();
            $totalSanPhamDaHet = Product_detail::with('product', 'firstImage', 'product.brand','color','size')->where('trangthai', 1)

                ->get();
        }

        $totalThuNhapTrangThai4 = $query->where('trangthai', 4)->sum('ttthanhtoan');
        $totalThuNhap -= $totalThuNhapTrangThai4;

        return view('admin.doanh-thu', compact('totalSanPham', 'totalDonHang', 'totalThuNhap', 'tongDonHang','totalSanPhamDaHet','SanPhamDaHet'));
    }

    public function exportPDF(Request $request)
    {

        $totalSanPham = Product::count();
        $SanPhamDaHet = Product_detail::where('trangthai', 1)->count();
        $sanPhamBanChay = Product::with('category')->get();
        // dd($sanPhamBanChay);
        $query = Order::query();
        if ($request->has('ngay')) {
            $ngay = Carbon::parse($request->ngay)->format('Y-m-d');
            $totalDonHang = $query->whereDate('ngay_lap_hoa_don', $ngay)->count();
            $totalThuNhap = $query->whereDate('ngay_lap_hoa_don', $ngay)->sum('ttthanhtoan');
            $tongDonHang = $query->with('khachangorder', 'orderdetail.product.category')
                ->whereDate('ngay_lap_hoa_don', $ngay)
                ->get();
            $totalSanPhamDaHet = Product_detail::with('product', 'firstImage', 'product.brand','color','size')->where('trangthai', 1)
                ->get();
        } else {
            $totalDonHang = $query->whereDate('ngay_lap_hoa_don', Carbon::today())->count();
            $totalThuNhap = $query->whereDate('ngay_lap_hoa_don', Carbon::today())->sum('ttthanhtoan');
            $tongDonHang = $query->with('khachangorder', 'orderdetail.product.category')
                ->whereDate('ngay_lap_hoa_don', Carbon::today())
                ->get();
                  $totalSanPhamDaHet = Product_detail::with('product', 'firstImage', 'product.brand','color','size')->where('trangthai', 1)
                ->get();
        }
        $totalThuNhapTrangThai4 = $query->where('trangthai', 4)->sum('ttthanhtoan');
        $totalThuNhap -= $totalThuNhapTrangThai4;
        $pdf = PDF::loadView('pdf.doanhthu', compact('totalSanPham', 'totalDonHang', 'totalThuNhap', 'tongDonHang', 'sanPhamBanChay', 'totalSanPhamDaHet','SanPhamDaHet'));
        return $pdf->download('report.pdf');
    }
}
