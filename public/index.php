<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/23
 * Time: 4:31 PM
 */
use \zzhpeng\Zzhpeng;
//require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'zzhpeng' . DIRECTORY_SEPARATOR . 'Zzhpeng.php'; //使用了composer后
require dirname(__DIR__) . "/vendor/autoload.php";
Zzhpeng::run();