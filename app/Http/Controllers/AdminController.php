<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admin = User::where('phanquyen', 1)->paginate(10);
        return view('admin.quan-li-nhan-vien', compact('admin'));
    }

    public function home()
    {
        // Lấy 5 đơn hàng mới nhất có các tình trạng khác nhau
        $orders = Order::whereIn('trangthai', [1, 2, 3]) // Lấy những đơn hàng có trạng thái là 1 (Chờ xử lý), 2 (Đang vận chuyển) và 3 (Đã Xong)
            ->with('orderdetail.product', 'khachangorder', 'orderstatus')
            ->latest() // Sắp xếp theo thời gian tạo mới nhất
            ->take(5) // Giới hạn chỉ lấy 5 đơn hàng
            ->get();
        //dd($orders); // Debug để xem kết quả của câu truy vấn
        // Lấy các thông tin khác như người dùng, sản phẩm, số lượng sản phẩm sắp hết hàng
        $users = User::where('phanquyen', '<>', 1) // Loại bỏ những người dùng có phân quyền là 1 (admin)
            ->latest() // Sắp xếp theo thời gian từ mới nhất đến cũ nhất
            ->take(5) // Giới hạn lấy chỉ 5 bản ghi
            ->get(); // Lấy dữ liệu

        $count = User::where('phanquyen', '<>', 1)->count(); // Đếm số người dùng không phải là admin
        $count_product = Product::count(); // Đếm số lượng sản phẩm
        $product_stt = Product::where('soluong', '<', 5)->count(); // Đếm số lượng sản phẩm sắp hết hàng

        // Đếm số lượng đơn hàng đã hoàn thành
        $completedOrdersCount = Order::where('trangthai', 3)->count();

        return view('admin.trang-chu', compact('users', 'count', 'count_product', 'product_stt', 'completedOrdersCount', 'orders'));
    }

    public function create()
    {
        $admin = User::where('trangthai', 0)->get();
        return view('admin.them-admin', compact('admin'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'sdt' => 'required|size:10',
            'hovaten' => 'required|max:30',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'diachi' => 'required|max:255',
            'phanquyen' => 'required',
            'gioitinh' => 'required',
            'ngaysinh' => 'required|date',
        ], [
            'sdt.required' => 'Không được để trống',
            'sdt.size' => 'Số điện thoại phải đủ 10 số',
            'email.required' => 'Không được để trống',
            'email.unique' => 'email đã tồn tại',
            'email.email' => 'Định dạng không hợp lệ',
            'hovaten.required' => 'Không được để trống',
            'hovaten.max' => 'Mật khẩu không quá 30 ký tự',
            'password.required' => 'Không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'diachi.max' => 'Địa chỉ không quá 255 ký tự',
            'diachi.required' => 'Không được để trống',
            'phanquyen.required' => 'Không được để trống',
            'gioitinh.required' => 'Không được để trống',
            'ngaysinh.required' => 'Không được để trống',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ',
        ]);

        $user = new User;
        $user->sdt = $request->input('sdt');
        $user->password = Hash::make($request->input('password'));
        $user->hovaten = $request->input('hovaten');
        $user->email = $request->input('email');
        $user->diachi = $request->input('diachi');
        $user->phanquyen = $request->input('phanquyen');
        $user->gioitinh = $request->input('gioitinh');
        $user->ngaysinh = $request->input('ngaysinh');
        $user->save();
        Alert()->success('Thành công', 'Thêm quản trị viên thành công.');
        return \redirect()->back();
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.chi-tiet-admin', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.chinh-sua-tai-khoan', [
            'item' => $user,
            'type' => 'quản trị viên',
            'nameField' => 'hovaten',
            'sdt' => 'sdt',
            'email' => 'email',
            'diachi' => 'diachi',
            'phanquyen' => 'phanquyen',
            'gioitinh' => 'gioitinh',
            'ngaysinh' => 'ngaysinh',
            'updateRoute' => route('cap-nhat-admin', ['id' => $user->id])
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sdt' => 'required|size:10',
            'hovaten' => 'required|max:30',
            'email' => 'required|email|unique:user,email,' . $id,
            'password' => 'nullable|min:6',
            'diachi' => 'required|max:255',
            'phanquyen' => 'required|in:1,2', // Chỉ chấp nhận giá trị 1 hoặc 2
            'gioitinh' => 'required',
            'ngaysinh' => 'required|date',
        ], [
            'sdt.required' => 'Không được để trống',
            'sdt.size' => 'Số điện thoại phải đủ 10 số',
            'email.required' => 'Không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Định dạng email không hợp lệ',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'diachi.required' => 'Không được để trống',
            'diachi.max' => 'Địa chỉ không quá 255 ký tự',
            'phanquyen.required' => 'Không được để trống',
            'phanquyen.in' => 'Phân quyền không hợp lệ',
            'gioitinh.required' => 'Không được để trống',
            'ngaysinh.required' => 'Không được để trống',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ',
        ]);

        $user = User::find($id);
        $user->hovaten = $request->input('hovaten') ?? $user->hovaten;
        $user->sdt = $request->input('sdt') ?? $user->sdt;
        $user->diachi = $request->input('diachi') ?? $user->diachi;
        $user->phanquyen = $request->input('phanquyen') ?? $user->phanquyen;
        $user->email = $request->input('email') ?? $user->email;
        $user->gioitinh = $request->input('gioitinh') ?? $user->gioitinh;
        $user->ngaysinh = $request->input('ngaysinh') ?? $user->ngaysinh;

        // Cập nhật mật khẩu nếu được cung cấp
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        Alert()->success('Thành công', 'Cập nhật tài khoản quản trị viên thành công.');
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        alert()->success('Thành công', 'Xóa tài khoản thành công');
        return redirect()->back();
    }

    public function user()
    {
        $users = User::latest()->take(5)->get(); // Lấy danh sách 5 người dùng mới nhất

        return view('admin.trang-chu', compact('users')); // Trả về view 'home' với dữ liệu người dùng
    }
}
