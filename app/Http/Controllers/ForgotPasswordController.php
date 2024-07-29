<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    // Gửi email reset mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        // Validate request data
        $request->validate(['email' => 'required|email']);
        // Attempt to send password reset link
        $response = Password::sendResetLink(
            $request->only('email')
        );
        // dd($response);

        // Check the response from Password::sendResetLink
        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    // Hiển thị form nhập mật khẩu mới với token
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Cập nhật mật khẩu mới
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('auth')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
