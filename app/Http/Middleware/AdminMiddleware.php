<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 1) {
            // Chuyển hướng về trang không được phép hoặc thực hiện xử lý phù hợp
            return redirect('/login')->with('error', 'Bạn không được phép đăng nhập vào admin!'); // Chẳng hạn, chuyển hướng về trang chính
        }
    
        return $next($request);
    }
}
