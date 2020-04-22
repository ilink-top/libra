<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;

class AuthPermission extends Permission
{
    use Concerns\DateFormat;

    protected $fillable = [
        'title', 'name','guard_name',
    ];

    public static function getMap($param = [])
    {
        $where = [];
        if (!empty($param['guard_name'])) {
            $where[] = ['guard_name', '=', $param['guard_name']];
        }
        return $where;
    }
}
