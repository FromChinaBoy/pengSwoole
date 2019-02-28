<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/27
 * Time: 10:28 PM
 */

return [
    'router' => function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/users', ['controller\Index', 'getlist']);
//        $r->addRoute('GET', '/user/{uid:\d+}', 'controller\Index@index');
        $r->addRoute('GET', '/user/{uid:\d+}', 'controller\Index@user');
        $r->get('/add', ['controller\Index', 'add']);
        $r->get('/test', function () {
            return "i am test";
        });
        $r->post('/post', function () {
            return "must post method";
        });
    },
];