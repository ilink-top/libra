<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;

class IndexController extends BaseController
{
    public function index()
    {
        return view('index.index', [
            'systemInfo' => [
                'os' => PHP_OS,
                'php_version' => PHP_VERSION,
                'upload_max_filesize' => get_cfg_var('upload_max_filesize') ? get_cfg_var('upload_max_filesize') : '不允许上传附件',
                'max_execution_time' => get_cfg_var('max_execution_time'),
            ],
            'lastLoginAdmins' => Admin::orderBy('logined_at', 'desc')->limit(8)->get(),
        ]);
    }
}
