<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class userMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->phanquyen == 2 && Auth::user()->trangthai == 0) {
                return $next($request);
            } elseif ((Auth::user()->trangthai == 1)) {
                Alert::error('Đăng nhập không thành công', 'Tài khoản bị vô hiệu hóa. Vui lòng liên hệ admin! ');
                return redirect()->back();
            } else {
                Alert::error('Đăng nhập không thành công', 'Tài khoản hoặc mật khẩu không chính xác! ');
                return redirect()->back();
            }
        } else {
            return \redirect()->route('dang-nhap');
        }
    }
}
