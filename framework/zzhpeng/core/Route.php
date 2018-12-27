<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/26
 * Time: 11:15 AM
 */

namespace zzhpeng\core;


class Route
{
    public static function dispatch($path)
    {
        //默认访问 controller/index.php 的 index方法
        if (empty($path) || '/' == $path) {
            $controller = 'Index';
            $method = 'index';
        } else {
            $maps = explode('/', $path);
            $controller = $maps[1];
            $method = $maps[2];
        }

        var_dump('controller');
        var_dump($controller);
        var_dump('method');
        var_dump($method);
        $controllerClass = "controller\\{$controller}";
        $class = new $controllerClass;

        return $class->$method();
    }

}