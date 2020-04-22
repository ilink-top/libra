<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\AdminMenu;
use Closure;
use Illuminate\Support\HtmlString;

class AdminView
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
        $view = app('view');

        // 设置 admin 视图目录
        $view->getFinder()->prependLocation(resource_path('views/admin'));

        // Laravel Collective Html Select 重写
        \Form::macro('mySelect', function (
            $name,
            $list = [],
            $prepend = [],
            $selected = null,
            array $selectAttributes = [],
            array $optionsAttributes = [],
            array $optgroupsAttributes = []
        ) {
            $data = (array) $prepend;
            if (\Arr::isAssoc($list)) {
                // 关联数组
                $data = array_merge($data, $list);
            } else {
                // 索引数组
                foreach ($list as $val) {
                    $data[$val] = $val;
                }
            }
            return \Form::select($name, $data, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
        });

        // 传输数据
        $view->share('system', $this->shareData($request));

        return $next($request);
    }

    private function shareData($request)
    {
        $uri = $request->route()->uri;
        $data = [];

        // 基本数据
        $menu = AdminMenu::where('uri', $uri)->first();
        $data['title'] = $menu->name ?? '';
        $data['desc'] = $menu->desc ?? '';

        // 登录用户
        $data['user'] = \Auth::guard(Admin::guardName())->user();

        // 面包屑导航
        $bread = AdminMenu::getBread([
            ['uri', '=', $uri],
        ]);
        $data['bread'] = $bread;

        // 左侧菜单
        $menu = AdminMenu::getTree();
        $data['menu'] = $this->treeview($menu, array_column($bread, 'id'));

        return $data;
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
