<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareWishlistCount
{
    public function handle($request, Closure $next)
    {
        $WishlistCount = 0;

        if (Auth::check()) {
            // Lấy số lượng sản phẩm trong giỏ hàng cho người dùng đã đăng nhập
            $WishlistCount = Wishlist::where('user_id', Auth::id())->count();
        }

        View::share('WishlistCount', $WishlistCount);

        return $next($request);
    }
}
