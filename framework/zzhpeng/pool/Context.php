<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/2
 * Time: 2:15 PM
 */
namespace zzhpeng\pool;

use zzhpeng\coroutine\Coroutine;

class Context
{
    /**
     * @var array context pool
     */
    public static $pool = [];

    /**
     * @return \Family\coroutine\Context
     * @desc 可以任意协程获取到context
     */
    public static function getContext()
    {
        $id = Coroutine::getPid();
        if (isset(self::$pool[$id])) {
            return self::$pool[$id];
        }

        return null;
    }

    /**
     * @desc 清除context
     */
    public static function clear()
    {
        $id = Coroutine::getPid();
        if (isset(self::$pool[$id])) {
            unset(self::$pool[$id]);
        }
    }

    /**
     * @param $context
     * @desc 设置context
     */
    public static function set($context)
    {
        $id = Coroutine::getPid();
        self::$pool[$id] = $context;
    }
}