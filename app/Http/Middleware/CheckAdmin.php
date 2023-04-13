<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckAdmin
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

        if (Auth::check() && (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))) {
            return $next($request);
        }
        return Redirect::route('auth.login'); //back()->withErrors(['msg' => 'Vui lòng đăng nhập hoặc đăng nhập với tài khoản với quyền Admin']);
    }
}
