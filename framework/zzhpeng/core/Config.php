<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/24
 * Time: 9:24 AM
 */
namespace zzhpeng\core;

use \zzhpeng\Zzhpeng;

class Config
{
    /**
     * @var 配置map
     */
    public static $configMap = [];

    /**
     * @desc 读取配置，默认是application/config/default.php
     */
    public static function load()
    {
        $configPath = Zzhpeng::$applicationPath . DS . 'config';
        //扫描文件夹
        $file = scandir($configPath);
        foreach ($file as $config){
            if(pathinfo($config)['extension'] == 'php'){
                self::$configMap = array_merge(self::$configMap,require $configPath . DS . $config);
            }
        }
    }

    /**
     * @param $key
     * @desc 读取配置
     * @return string|null
     *
     */
    public static function get($key)
    {
        if(isset(self::$configMap[$key])) {
            return self::$configMap[$key];
        }

        return null;
    }
}