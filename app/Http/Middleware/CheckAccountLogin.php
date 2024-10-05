<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountLogin
{
    public function handle($request, Closure $next)
    {
        // Lấy username từ path
        $pathUsername = $request->path();
        // dd($pathUsername);
        // Lấy username của người dùng đăng nhập
        $loggedInUsername = Auth::user()->username;

        // Kiểm tra nếu trùng khớp, cho phép tiếp tục
        if ($pathUsername === $loggedInUsername) {
            return $next($request);
        }

        // Nếu không trùng khớp, trả về lỗi hoặc redirect
        return redirect()->route('home')->withErrors(['message' => 'Unauthorized access.']);
    }
}
