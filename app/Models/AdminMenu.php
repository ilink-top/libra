<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class AdminMenu extends Model
{
    use Concerns\DateFormat;

    private static $cacheKey = 'admin.menu';

    protected $fillable = [
        'pid', 'icon', 'name', 'desc', 'sort',
    ];

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $value ?: 'fa-circle-o';
    }

    public static function getMenu()
    {
        return Cache::rememberForever(self::$cacheKey, function () {
            return self::orderBy('sort', 'asc')->get();
        });
    }

    public static function getBread($where = [], $bread = [])
    {
        $list = self::getMenu();
        $info = self::where($where)->first();
        return !empty($info) ? \Tree::bread($list, $info->id) : [];
    }

    public static function getTree()
    {
        $list = self::getMenu()->filter(function ($row) {
            $url = url($row->uri);
            if (!is_string($url)) {
                return true;
            }
            return admin_user()->isDisabledUrl($url) === false;
        });
        $list = \Tree::tree($list);
        $list = self::clearEmptyMenu($list);
        return $list;
    }

    public static function clearEmptyMenu($list)
    {
        $data = [];
        foreach ($list as $key => $row) {
            if (!empty($row->uri) || !empty($row->children)) {
                $data[$key] = $row;
            }
        }
        return $list == $data ? $data : self::clearEmptyMenu($data);
    }

    public static function getTreeList($where = [])
    {
        $list = self::where($where)->orderBy('sort', 'asc')->get();
        $list = \Tree::list($list);
        return $list;
    }

    public static function getTreeData($where = [])
    {
        $list = self::getTreeList($where);
        $list = \Tree::data($list);
        return $list;
    }
}
