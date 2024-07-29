<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareCartCount
{
    public function handle($request, Closure $next)
    {
        $cartCount = 0;

        if (Auth::check()) {
            // Lấy số lượng sản phẩm trong giỏ hàng cho người dùng đã đăng nhập
            $cartCount = Cart::where('user_id', Auth::id())->count();
        }

        View::share('cartCount', $cartCount);

        return $next($request);
    }
}
