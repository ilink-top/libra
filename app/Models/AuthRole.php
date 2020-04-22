<?php

namespace App\Models;

use Spatie\Permission\Models\Role;

class AuthRole extends Role
{
    use Concerns\DateFormat;

    protected $fillable = [
        'name', 'guard_name',
    ];

    public function getPermissionIdAttribute()
    {
        return $this->getAllPermissions()->pluck('id');
    }

    public static function getMap($param = [])
    {
        $where = [];
        if (!empty($param['guard_name'])) {
            $where[] = ['guard_name', '=', $param['guard_name']];
        }
        return $where;
    }

    public static function getData($where = [])
    {
        return self::where($where)->pluck('name', 'id');
    }
}
