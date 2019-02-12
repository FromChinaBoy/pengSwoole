<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/27
 * Time: 4:42 PM
 */

namespace zzhpeng\core;

use \zzhpeng\Zzhpeng;
use SeasLog;

class Log
{

    //设置日志目录
    public static function init()
    {
        SeasLog::setBasePath(Zzhpeng::$rootPath. DS . 'log');
    }

    //代理seaglog的静态方法，如 SeasLog::debug
    public static function __callStatic($name, $arguments)
    {
        forward_static_call_array(['SeasLog', $name], $arguments);
    }
}