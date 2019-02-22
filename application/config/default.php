<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/23
 * Time: 4:40 PM
 */

return [
    'host' => '0.0.0.0',
    'port' => 9502,
    'swoole_setting' => [
         'worker_num' => 1
    ],
    'mysql' => [
        'pool_size' => 3,     //连接池大小
        'pool_get_timeout' => 0.5, //当在此时间内未获得到一个连接，会立即返回。（表示所以的连接都已在使用中）
        'master' => [
            'host' => '127.0.0.1',   //数据库ip
            'port' => 3306,          //数据库端口
            'user' => 'root',        //数据库用户名
            'password' => '12345678', //数据库密码
            'database' => 'peng_swoole',   //默认数据库名
            'timeout' => 0.5,       //数据库连接超时时间
            'charset' => 'utf8mb4', //默认字符集
            'strict_type' => true,  //ture，会自动表数字转为int类型
        ],
    ],
    'router' => function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/users', ['controller\Index', 'getlist']);
        $r->addRoute('GET', '/user/{uid:\d+}', 'controller\Index@index');
        $r->get('/add', ['controller\Index', 'add']);
        $r->get('/test', function () {
            return "i am test";
        });
        $r->post('/post', function () {
            return "must post method";
        });
    },
    'template' => [
        //模板页面的存放目录
        'path' => \zzhpeng\Zzhpeng::$applicationPath . DS . 'template' . DS . 'default',    //模版目录, 空则默认 template/default
        //模板缓存页面的存放目录
        'cache' => \zzhpeng\Zzhpeng::$applicationPath . DS . 'template' . DS . 'default_cache',    //缓存目录, 空则默认 template/default_cache
    ],
    'time_zone'=>'Asia/Shanghai'
];