<?php

namespace App\Http\Middleware;

use Closure;

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
        // 设置 admin 视图目录
        app('view')->getFinder()->prependLocation(resource_path('views/admin'));

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

        return $next($request);
    }
}
