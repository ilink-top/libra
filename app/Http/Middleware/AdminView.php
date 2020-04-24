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
            return $this->select($name, $data, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
        });

        // Laravel Collective Html File 重写
        \Form::macro('myFile', function ($name, $value = null, $options = []) {
            $valueArray = explode(',', $this->getValueAttribute($name, $value));
            foreach ($valueArray as $key => $val) {
                $valueArray[$key] = asset($val);
            }
            $options['data-value'] = implode(',', $valueArray);
            return $this->file($name, $options);
        });

        return $next($request);
    }
}
