<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\AuthPermission;
use Closure;

class AdminAuth
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
        $route = $request->route()->getName();
        $guard = \Auth::guard(Admin::guardName());

        // 未登录
        if ($guard->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()
                    ->route('admin.login')
                    ->with('toastr', 'error')
                    ->with('message', '请登录');
            }
        }

        // 无权限
        $routePermission = AuthPermission::where('name', $route)->where('guard_name', Admin::guardName())->count();
        if ($routePermission && $guard->user()->cannot($route)) {
            // if ($request->ajax() || $request->wantsJson()) {
            //     return response('Unauthorized.', 401);
            // } else {
            //     return redirect()
            //         ->route('admin.home')
            //         ->with('toastr', 'error')
            //         ->with('message', '无权限');
            // }
        }

        return $next($request);
    }
}
