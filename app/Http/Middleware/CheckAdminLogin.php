<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //用户是否登录检查
        if(!auth()->check()){
            return redirect(route('admin.login'))->withErrors(['error'=>'请登录']);
        }
        return $next($request);
    }
}
