<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Tree extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Support\Tree::class;
    }
}