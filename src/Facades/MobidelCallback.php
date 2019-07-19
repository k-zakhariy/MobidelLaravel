<?php


namespace Zakhariy\MobidelLaravel\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class MobidelCallback
 * @package Zakhariy\MobidelLaravel\Facades
 * @see \Zakhariy\MobidelLaravel\MobidelCallback
 */
class MobidelCallback extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mobidel_callback';
    }
}