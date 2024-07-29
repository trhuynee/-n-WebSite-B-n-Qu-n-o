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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session; // Import Session
use PDF;


class NhapXuaController extends Controller
{

    public function index(Request $request)
    {
        $tonKho = Product::get();
        $query = Product::query();
        $orderquery = Order::query();

        if ($request->has('ngay')) {
            $ngay = Carbon::parse($request->ngay)->format('Y-m-d');
            $sanPhamNhap = $query->whereDate('created_at', $ngay)->get();
            $sanPhamXuat = $orderquery->with('orderdetail.product')->whereDate('ngay_lap_hoa_don', $ngay)->get();
        } else {
            $sanPhamNhap = $query->whereDate('created_at', Carbon::today())->get();
            $sanPhamXuat = $orderquery->whereDate('ngay_lap_hoa_don', Carbon::today())->get();
        }

        return view('admin.nhap-xuat', compact('tonKho', 'sanPhamNhap', 'sanPhamXuat'));
    }


    public function exportPDF(Request $request)
    {

        $tonKho = Product::get();
        $query = Product::query();
        $orderquery = Order::query();


        if ($request->has('ngay')) {
            $ngay = Carbon::parse($request->ngay)->format('Y-m-d');
            $sanPhamNhap = $query->whereDate('created_at', $ngay)->get();
            $sanPhamXuat = $orderquery->with('orderdetail.product')->whereDate('ngay_lap_hoa_don', $ngay)->get();
        } else {
            $ngay = Carbon::today()->format('Y-m-d');
            $sanPhamNhap = $query->whereDate('created_at', $ngay)->get();
            $sanPhamXuat = $query->whereDate('created_at', $ngay)->get();
        }
        $pdf = PDF::loadView('pdf.xuat-nhap', compact('tonKho', 'sanPhamNhap', 'sanPhamXuat'));
        return $pdf->download('bao_cao_xuat_nhap_ton.pdf');
    }


    public function fetchData()
    {
        $months = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];
        $sanPhamNhapData = [];
        $sanPhamXuatData = [];

        foreach ($months as $key => $month) {
            $startDate = Carbon::create(Carbon::now()->year, $key + 1, 1)->startOfMonth();
            $endDate = Carbon::create(Carbon::now()->year, $key + 1, 1)->endOfMonth();
            info("Calculating data for month $month: Start date: " . $startDate->toDateString() . ", End date: " . $endDate->toDateString());

            $sanPhamNhapCount = Product::whereBetween('created_at', [$startDate, $endDate])->count();
            $sanPhamXuatCount = Order::whereBetween('ngay_lap_hoa_don', [$startDate, $endDate])->count();

            info("SanPhamNhapCount: " . $sanPhamNhapCount);
            info("SanPhamXuatCount: " . $sanPhamXuatCount);

            $sanPhamNhapData[$month] = $sanPhamNhapCount;
            $sanPhamXuatData[$month] = $sanPhamXuatCount;
        }

        $data = [
            'sanPhamNhapData' => $sanPhamNhapData,
            'sanPhamXuatData' => $sanPhamXuatData,
        ];

        return response()->json($data);
    }
}
