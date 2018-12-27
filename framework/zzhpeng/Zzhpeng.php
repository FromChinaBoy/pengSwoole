<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/23
 * Time: 6:05 PM
 */
namespace framework\zzhpeng;

use zzhpeng\core\Config;
use zzhpeng\core\Route;

class Zzhpeng
{
    final public static function run(){
        //先注册自动加载
        \spl_autoload_register(__CLASS__ . '::autoLoader');

        //加载配置
        Config::load();

        $http = new \Swoole\Http\Server(Config::get('host'), Config::get('port'));
        $http->set([
            "worker_num" => Config::get('worker_num'),
        ]);
        $http->on('request', function ($request, $response) {
//          $response->end("hello, family is run");
            //自动路由
            if($request->server['path_info'] == '/favicon.ico') {
                $response->status(404);
                $response->end();
                return ;
            }

            try {
                //自动路由
                $result = Route::dispatch($request->server['path_info']);
                $response->end($result);
            } catch (\Exception $e) {
                $response->end($e->getMessage());
            } catch (\Error $e) {
                $response->end($e->getMessage());
            }

        });
        $http->start();
    }

    final public static function autoLoader($class)
    {
        //定义rootPath
        $rootPath = dirname(dirname(__DIR__));
        //把类转为目录，eg \a\b\c => /a/b/c.php
        $classPath = \str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        //约定框架类都在framework目录下, 业务类都在application下
        $findPath = [
            $rootPath . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR,
            $rootPath . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR,
        ];

        //遍历目录，查找文件
        foreach ($findPath as $path) {
            //如果找到文件，则require进来
            $realPath = $path . $classPath;
            if (is_file($realPath)) {
                require "{$realPath}";
                var_dump($realPath);
                return;
            }
        }
        exit;

    }

}