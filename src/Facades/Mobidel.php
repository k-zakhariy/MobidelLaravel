<?php

namespace Zakhariy\MobidelLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Mobidel
 * @package Zakhariy\MobidelLaravel\Facades
 * @see \Zakhariy\MobidelLaravel\MobidelApi
 */
class Mobidel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mobidel_api';
    }
}