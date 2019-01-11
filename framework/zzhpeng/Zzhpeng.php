<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/23
 * Time: 6:05 PM
 */
namespace framework\zzhpeng;

use zzhpeng\core\Config;
use zzhpeng\core\Log;
use zzhpeng\core\Route;

class Zzhpeng
{
    /**
     * @var 根目录
     */
    public static $keys;

    public static $rootPath;
    /**
     * @var 框架目录
     */
    public static $frameworkPath;
    /**
     * @var 程序目录
     */
    public static $applicationPath;


    final public static function run(){
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        self::$rootPath = dirname(dirname(__DIR__));
        self::$frameworkPath = self::$rootPath . DS . 'framework';
        self::$applicationPath = self::$rootPath . DS . 'application';


        //先注册自动加载
        \spl_autoload_register(__CLASS__ . '::autoLoader');

        //加载配置
        Config::load();

        //日志初始化
        Log::init();

        $http = new \Swoole\Http\Server(Config::get('host'), Config::get('port'));
        $http->set([
            "worker_num" => Config::get('worker_num'),
        ]);
        $http->on('request', function ( $request, $response) {
//          $response->end("hello, family is run");
            //自动路由
            if($request->server['path_info'] == '/favicon.ico') {
                $response->status(404);
                $response->end();
                return ;
            }

            $key = $request->get['keys'];
            if($key){
               self::$keys = $key;
            }

            if ($key == 'sleep') {
                //模拟耗时操作
                sleep(10);
            }
            $response->end(self::$keys);
//
//            try {
//                //自动路由
//                $result = Route::dispatch($request->server['path_info']);
//                $response->end($result);
//            } catch (\Exception $e) { //程序异常
//                print_r('Exception-' . $e->getMessage());
//                Log::alert($e->getMessage(), $e->getTrace());
//                $response->end($e->getMessage());
//            } catch (\Error $e) { //程序错误，如fatal error
//                print_r($e->getMessage());
//                Log::emergency($e->getMessage(), $e->getTrace());
//                $response->status(500);
//            } catch (\Throwable $e) {  //兜底
//                print_r('Throwable-' . $e->getMessage());
//                Log::emergency($e->getMessage(), $e->getTrace());
//                $response->status(500);
//            }

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
            self::$frameworkPath . DS,
            self::$applicationPath . DS,
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