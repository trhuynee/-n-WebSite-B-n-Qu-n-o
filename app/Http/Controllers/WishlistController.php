<?php

namespace App\Http\Controllers;


use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WishlistController extends Controller
{
 public function index(Request $request)
{
    $user = Auth::user();
     if ($user) {
            $wishlistItems = Wishlist::with('product', 'product.image')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
            $tong = 0;

            foreach ($wishlistItems as $item) {
                $item['isPayment'] = false;
                $tong += $item->dongia * $item->soluong;
                //$firstImage = $item->productDetail->firstImage;
                Log::info($item);
            }

            Log::info($wishlistItems->pluck('productDetail.sanpham_id'));
            // Retrieve images related to product details in the cart
            // dd($giohang);

            return view('user.wishlist', compact('wishlistItems', 'tong'));
        } else {
            return redirect()->route('auth');
        }
}

    public function add(Request $request)
{
    if (!Auth::check()) {
            return redirect()->route('auth');
        }
    // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
    $productId = $request->input('product_id');

    // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích của người dùng chưa
    $wishlistItem = Wishlist::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->first();

    if ($wishlistItem) {
        alert()->success('Chú ý', 'Sản phẩm đã có trong danh sách yêu thích.');
        return \redirect()->back();
    }

    // Nếu chưa có, thêm vào danh sách yêu thích
    $wishlist = new Wishlist();
    $wishlist->user_id = Auth::id();
    $wishlist->product_id = $productId;
    $wishlist->save();

    alert()->success('Thành công', 'Đã thêm vào danh sách yêu thích.');
    return \redirect()->back();
}

public function remove(Request $request, $id)
{
    $wishlist = Wishlist::find($id);

    if (empty($wishlist))
    {
        return false;
    }

    $wishlist->delete();

    alert()->success('Thành công', 'Đã xoá thành công.');
    return \redirect()->back();
}

}

