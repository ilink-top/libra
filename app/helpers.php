<?php

// 记录日志
if (!function_exists('trace')) {
    function trace($message, array $context = [], $level = 'info')
    {
        Log::log($level, $message, $context);
    }
}

// 打印SQL记录
if (!function_exists('querylog')) {
    function querylog()
    {
        DB::listen(function ($query) {
            foreach ($query->bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $query->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $query->bindings[$i] = "'$binding'";
                    }
                }
            }

            $sql = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);

            $sql = vsprintf($sql, $query->bindings);

            trace($sql . PHP_EOL);
        });
    }
}

// 文件读取路径
if (!function_exists('upload_path')) {
    function upload_path() {
        return date('Ymd');
    }
}

// 获取所有 guards 名称
if (!function_exists('guards')) {
    function guards()
    {
        return array_keys(config('auth.guards'));
    }
}

// 获取后台 guard
if (!function_exists('admin_guard')) {
    function admin_guard()
    {
        return Auth::guard(App\Models\Admin::guardName());
    }
}

// 获取后台 user
if (!function_exists('admin_user')) {
    function admin_user()
    {
        return admin_guard()->user();
    }
}