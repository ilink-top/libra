<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AuthPermission;
use Closure;
use Illuminate\Support\HtmlString;

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
        $route = $request->route();
        $user = admin_user();

        // 未登录
        if (admin_guard()->guest()) {
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
        $routePermission = AuthPermission::where('name', $route->getName())->where('guard_name', Admin::guardName())->count();
        if ($routePermission && $user->cannot($route->getName())) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()
                    ->route('admin.home')
                    ->with('toastr', 'error')
                    ->with('message', '无权限');
            }
        }

        // 共享数据
        $systemData = [];

        // 基本数据
        $menu = AdminMenu::where('uri', $route->uri)->first();
        $systemData['title'] = $menu->name ?? '';
        $systemData['desc'] = $menu->desc ?? '';

        // 登录用户
        $systemData['user'] = $user;

        // 面包屑导航
        $bread = AdminMenu::getBread([
            ['uri', '=', $route->uri],
        ]);
        $systemData['bread'] = $bread;

        // 左侧菜单
        $menu = AdminMenu::getTree();
        $systemData['menu'] = $this->treeview($menu, array_column($bread, 'id'));

        app('view')->share('system', $systemData);

        return $next($request);
    }

    private function treeview($menu, $actives = [])
    {
        $html = '';
        foreach ($menu as $row) {
            $class = [];
            $url = $row->uri ? url($row->uri) : '#';
            $name = '<i class="fa ' . $row->icon . '"></i> <span>' . $row->name . '</span>';
            $treeview = '';

            if (!empty($row->children)) {
                $class[] = 'treeview';
                $name .= '<span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>';
                $treeview = '<ul class="treeview-menu">' . $this->treeview($row->children, $actives) . '</ul>';
            }
            if (in_array($row->id, $actives)) {
                $class[] = 'active';
            };

            $html .= '<li class="' . implode(' ', $class) . '">
                <a href="' . $url . '">
                    ' . $name . '
                </a>
                ' . $treeview . '
            </li>';
        }

        return new HtmlString($html);
    }
}
