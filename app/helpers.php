<?php

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

            Log::info($sql . PHP_EOL);
        });
    }
}

// 文件读取路径
if (!function_exists('upload_path')) {
    function upload_path() {
        return date('Ymd');
    }
}

// 获取所有guards名称
if (!function_exists('guards')) {
    function guards()
    {
        return array_keys(config('auth.guards'));
    }
}