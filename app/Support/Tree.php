<?php

namespace App\Support;

class Tree
{
    private $column = [
        'id' => 'id',
        'pid' => 'pid',
        'name' => 'name',
        'level' => 'level',
        'children' => 'children',
    ];

    public function setColumn($column = [])
    {
        $this->column = array_merge($this->column, $column);
        return $this;
    }

    public function tree($list, $pid = 0)
    {
        $data = [];
        foreach ($list as $row) {
            if ($row[$this->column['pid']] == $pid) {
                $row[$this->column['children']] = $this->tree($list, $row[$this->column['id']]);
                $data[] = $row;
            }
        }
        return $data;
    }

    // 树形列表
    public function list($list, $pid = 0, $level = 1)
    {
        $data = [];
        foreach ($list as $row) {
            if ($row[$this->column['pid']] == $pid) {
                $row[$this->column['level']] = $level;
                $data[] = $row;
                $data = array_merge($data, $this->list($list, $row[$this->column['id']], $level + 1));
            }
        }
        return $data;
    }

    // 树形列表关联数组
    public function data($list, $str = '-')
    {
        $data = [];
        foreach ($list as $row) {
            $name = $row['name'];
            for ($i = 0; $i < $row[$this->column['level']]; $i++) {
                $name = $str . $name;
            }
            $data[$row[$this->column['id']]] = $name;
        }
        return $data;
    }

    // 面包屑
    public function bread($list, $id, $bread = [])
    {
        foreach ($list as $row) {
            if ($row[$this->column['id']] == $id) {
                $bread[] = $row;
                return $this->bread($list, $row[$this->column['pid']], $bread);
            }
        }
        return array_reverse($bread);
    }
}
