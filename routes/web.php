<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChungController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use Egulias\EmailValidator\Result\Reason\DomainHyphened;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DoanhThuController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NhapXuaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Đăng nhập
 */
Route::get('/auth', function () {
    return view('auth');
})->name('auth');
Route::post('/login', [LoginController::class, 'login'])->name('xu-li-dang-nhap');
Route::post('/register', [LoginController::class, 'register'])->name('xu-li-dang-ki');
// Route cho trang chủ khách hàng
Route::get('/', function () {
    return view('user.index');
})->name('trang-chu-user');

// Route cho trang quản trị
Route::get('/trang-chu', function () {
    return view('admin.trang-chu');
})->name('trang-chu');



//Route profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});
//Route bill
Route::get('/bill', [UserController::class, 'billUser'])->name('billUser');
Route::get('/get-bill-user/{id}', [UserController::class, 'billShow'])->name('billShow');
Route::put('/update-bill-user/{id}', [UserController::class, 'billUpdate'])->name('billUpdate');
// Route cho đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('dang-xuat');




Route::get('/', [ProductController::class, 'index_user'])->name('trang-chu-user');
Route::get('/search', [ProductController::class, 'index_user'])->name('tim-kiem-user');
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('chi-tiet-san-pham-user');
Route::get('/shop', [ProductController::class, 'shop'])->name('trang-san-pham');
Route::get('/brand/{id}', [ProductController::class, 'brand'])->name('trang-nhan-hieu');
Route::get('/category/{id}', [ProductController::class, 'category'])->name('trang-loai');
Route::get('/search', [ProductController::class, 'search_user'])->name('tim-kiem-khach-hang');

Route::get('/shop/search', [ProductController::class, 'search'])->name('tim-kiem');
Route::get('/getrating/{product_id}', [RatingController::class, 'getRating'])->name('xem-danh-gia-san-pham');
Route::post('/rating', [RatingController::class, 'postRating'])->name('danh-gia-san-pham');

Route::get('/cart', [CartController::class, 'index'])->name('gio-hang');
Route::post('/cart/add', [CartController::class, 'add'])->name('them-gio-hang');
Route::post('/mua-ngay', [CartController::class, 'buyNow'])->name('mua-ngay');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('xoa-gio-hang');
Route::post('/update-cart/{id}', [CartController::class, 'update'])->name('cap-nhat-so-luong');


Route::get('/checkout-cart', [CartController::class, 'checkout'])->name('checkout');
Route::post('/create-order', [CartController::class, 'storeOrder'])->name('tao-hoa-don');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('thanh-toan');

// Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('xu-li-thanh-toan');
// Route::post('/dat-hang', [CheckoutController::class, 'placeOrder'])->name('dat-hang');

Route::post('/mua-hang-test', [CheckoutController::class, 'placeOrder'])->name('mua-hang-test');
Route::get('/order', function () {
    return view('user.order');
});



// Route::get('/checkout', function () {
//     return view('user.checkout');
// });

Route::get('/contact', function () {
    return view('user.contact');
});
Route::get('/intro/brand', function () {
    return view('user.doi-tac');
});
Route::get('/intro', function () {
    return view('user.intro');
});

// Admin (9)

Route::get('/quan-li-nhan-vien', function () {
    return view('admin.quan-li-nhan-vien');
});

Route::get('/quan-li-khach-hang', function () {
    return view('admin.quan-li-khach-hang');
});

Route::get('/quan-li-don-hang', function () {
    return view('admin.quan-li-don-hang');
});



Route::get('/quan-li-don-hang', [OrderController::class, 'getorder'])->name('quan-li-don-hang');
Route::get('/get-order-details/{id}', [OrderController::class, 'show'])->name('chinh-sua-don-hang');
Route::put('/update-status/{id}', [OrderController::class, 'update'])->name('thay-doi-trang-thai-don-hang');
Route::get('/export-pdf', [OrderController::class, 'exportPDF'])->name('export-pdf');
Route::get('/exportdetail-pdf/{id}', [OrderController::class, 'exportPDFdetail'])->name('exportdetail-pdf');

Route::get('/quan-li-san-pham', function () {
    return view('admin.quan-li-san-pham');
});


Route::get('/doanh-thu', function () {
    return view('admin.doanh-thu');
});
Route::get('/doanh-thu', [DoanhThuController::class, 'index'])->name('doanh-thu');
Route::get('/doanh-thu-pdf', [DoanhThuController::class, 'exportPDF'])->name('doanh-thu-pdf');



Route::get('/nhap-xuat', [NhapXuaController::class, 'index'])->name('nhap-xuat');
Route::get('/xuat-nhap-pdf', [NhapXuaController::class, 'exportPDF'])->name('xuat-nhap-pdf');





Route::get('/them-san-pham', function () {
    return view('admin.them-san-pham');
});

Route::get('/them-don-hang', function () {
    return view('admin.them-don-hang');
});

Route::get('/them-nhan-vien', function () {
    return view('admin.them-nhan-vien');
});

Route::get('/danh-sach-chung', function () {
    return view('admin.danh-sach-chung');
});


Route::get('/quan-li-san-pham', [ProductController::class, 'index_ad'])->name('quan-li-san-pham');
Route::get('/them-san-pham', [ProductController::class, 'create'])->name('them-san-pham');

Route::get('/them-san-pham-con/{id}', [ProductController::class, 'create_child'])->name('them-san-pham-con');
Route::post('/them-san-pham-con/{id}', [ProductController::class, 'add_child'])->name('xu-li-them-con');
Route::delete('/xoa-san-pham-con/{id}', [ProductController::class, 'delete_child'])->name('delete_child');

Route::post('/them-san-pham', [ProductController::class, 'store'])->name('xu-li-them-san-pham');
Route::get('/chi-tiet-san-pham/{id}', [ProductController::class, 'show'])->name('chi-tiet-san-pham');
Route::get('/chinh-sua-san-pham/{id}', [ProductController::class, 'edit'])->name('chinh-sua-san-pham');
Route::post('cap-nhat-san-pham/{id}', [ProductController::class, 'update'])->name('cap-nhat-san-pham');

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});


Route::delete('/xoa-san-pham/{id}', [ProductController::class, 'destroy'])->name('xoa-san-pham');

Route::get('/danh-sach-chung', [ChungController::class, 'index'])->name('danh-sach-chung');


Route::post('/them-nhan-hieu', [ChungController::class, 'store1'])->name('them-nhan-hieu');
Route::get('/chinh-sua-nhan-hieu/{id}', [BrandController::class, 'edit'])->name('chinh-sua-nhan-hieu');
Route::post('/cap-nhat-nhan-hieu/{id}', [BrandController::class, 'update'])->name('cap-nhat-nhan-hieu');
Route::delete('/xoa-nhan-hieu/{id}', [BrandController::class, 'destroy'])->name('xoa-nhan-hieu');

Route::post('/them-kich-thuoc', [ChungController::class, 'store2'])->name('them-kich-thuoc');
Route::get('/chinh-sua-kich-thuoc/{id}', [SizeController::class, 'edit'])->name('chinh-sua-kich-thuoc');
Route::post('/cap-nhat-kich-thuoc/{id}', [SizeController::class, 'update'])->name('cap-nhat-kich-thuoc');
Route::delete('/xoa-kich-thuoc/{id}', [SizeController::class, 'destroy'])->name('xoa-kich-thuoc-hieu');

Route::post('/them-mau-sac', [ChungController::class, 'store3'])->name('them-mau-sac');
Route::get('/chinh-sua-mau-sac/{id}', [ColorController::class, 'edit'])->name('chinh-sua-mau-sac');
Route::post('/cap-nhat-mau-sac/{id}', [ColorController::class, 'update'])->name('cap-nhat-mau-sac');
Route::delete('/xoa-mau-sac/{id}', [ColorController::class, 'destroy'])->name('xoa-mau-sac');

Route::post('/them-loai', [ChungController::class, 'store4'])->name('them-loai');
Route::get('/chinh-sua-loai/{id}', [CategoryController::class, 'edit'])->name('chinh-sua-loai');
Route::post('/cap-nhat-loai/{id}', [CategoryController::class, 'update'])->name('cap-nhat-loai');
Route::delete('/xoa-loai/{id}', [CategoryController::class, 'destroy'])->name('xoa-loai');


Route::get('/trang-chu', [AdminController::class, 'home'])->name('trang-chu');
Route::get('/quan-li-nhan-vien', [AdminController::class, 'index'])->name('quan-li-nhan-vien');


Route::get('/them-admin', [AdminController::class, 'create'])->name('them-admin');
Route::post('/them-admin', [AdminController::class, 'store'])->name('xu-li-them-admin');
Route::get('/chi-tiet-admin/{id}', [AdminController::class, 'show'])->name('chi-tiet-admin');
Route::get('/chinh-sua-tai-khoan/{id}', [AdminController::class, 'edit'])->name('chinh-sua-tai-khoan');
Route::post('/cap-nhat-admin/{id}', [AdminController::class, 'update'])->name('cap-nhat-admin');
Route::delete('/xoa-admin/{id}', [AdminController::class, 'destroy'])->name('xoa-admin');



Route::get('/quan-li-khach-hang', [UserController::class, 'index'])->name('quan-li-khach-hang');
Route::get('/chi-tiet-user/{id}', [UserController::class, 'show'])->name('chi-tiet-user');
Route::delete('/xoa-user/{id}', [UserController::class, 'destroy'])->name('xoa-user');


//ForgotPassword
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
// Route để xử lý việc gửi email reset mật khẩu
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route để hiển thị form reset mật khẩu với token
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
// Route để xử lý việc cập nhật mật khẩu mới
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
//Paypal
Route::post('/payment', [PaymentController::class, 'vn_pay'])->name('vnpay-payment');
Route::post('/payment/callback', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/payment/callback', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');


Route::get('/fetch-data', [NhapXuaController::class, 'fetchData'])->name('fetch.data');
