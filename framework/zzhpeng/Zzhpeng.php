<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/23
 * Time: 6:05 PM
 */
//namespace framework\zzhpeng;  composer 更改命名
namespace zzhpeng;
use zzhpeng\core\Config;
use zzhpeng\core\Log;
use zzhpeng\core\Route;
use zzhpeng\coroutine\Coroutine;
use zzhpeng\pool\Mysql as MysqlPool;


//use Swoole;

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
        try {
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

            $timeZone = Config::get('time_zone');
            \date_default_timezone_set($timeZone);

            $http = new \Swoole\Http\Server(Config::get('host'), Config::get('port'));
            $http->set(Config::get('swoole_setting'));

            $http->on('start', function (\swoole_server $serv) {
                //服务启动
                //日志初始化
                Log::init();
                file_put_contents(self::$rootPath . DS . 'bin' . DS . 'master.pid', $serv->master_pid);
                file_put_contents(self::$rootPath . DS . 'bin' . DS . 'manager.pid', $serv->manager_pid);
                Log::info("http server start! {host}: {port}, masterId:{masterId}, managerId: {managerId}", [
                    '{host}' => Config::get('host'),
                    '{port}' => Config::get('port'),
                    '{masterId}' => $serv->master_pid,
                    '{managerId}' => $serv->manager_pid,
                ]);
            });

            $http->on('shutdown', function () {
                //服务关闭，删除进程id
                unlink(self::$rootPath . DS . 'bin' . DS . 'master.pid');
                unlink(self::$rootPath . DS . 'bin' . DS . 'manager.pid');
                Log::info("http server shutdown");
            });

            //初始化连接池
            $http->on('workerStart', function (\swoole_http_server $serv, int $worker_id) {
    //            print_r(get_included_files());
                if (function_exists('opcache_reset')) {
                    //清除opcache 缓存，swoole模式下其实可以关闭opcache
                    \opcache_reset();
                }
                try {
                    $mysqlConfig = Config::get('mysql');
                    if (!empty($mysqlConfig)) {
                        //配置了mysql, 初始化mysql连接池
                        MysqlPool::getInstance($mysqlConfig);
                    }
                } catch (\Exception $e) {
                    //初始化异常，关闭服务
                    print_r('mysql-');
                    print_r($e->getMessage());
                    $serv->shutdown();
                } catch (\Throwable $throwable) {
                    //初始化异常，关闭服务
                    print_r('mysql-');
                    print_r($throwable);
                    $serv->shutdown();
                }
            });

            //初始化http请求
            $http->on('request', function (\swoole_http_request $request, \swoole_http_response $response) {
                //先过滤ico
    //            if($request->server['path_info'] == '/favicon.ico') {
    //                $response->status(404);
    //                $response->end();
    //                return ;
    //            }

                /**
                 * 初始化根协程ID
                 */
                Coroutine::setBaseId();
                //初始化上下文
                $context = new \zzhpeng\coroutine\Context($request, $response);
                //存放容器pool
                \zzhpeng\pool\Context::getInstance()->set($context);
                //协程退出，自动清空 需要Swoole版本 >= 4.2.9
                defer(function (){
                    //清空当前pool的上下文，释放资源
                    \zzhpeng\pool\Context::getInstance()->clear();
                });


                try {
                    //自动路由
                    $result = Route::dispatch();
                    $response->end($result);
                } catch (\Exception $e) { //程序异常
                    print_r('Exception-' . $e->getMessage());
                    Log::alert($e->getMessage(), $e->getTrace());
                    $response->end($e->getMessage());
                } catch (\Error $e) { //程序错误，如fatal error
                    print_r($e->getMessage());
                    Log::emergency($e->getMessage(), $e->getTrace());
                    $response->status(500);
                } catch (\Throwable $e) {  //兜底
                    print_r('Throwable-' . $e->getMessage());
                    Log::emergency($e->getMessage(), $e->getTrace());
                    $response->status(500);
                }

            });
            $http->start();
        } catch (\Exception $e) {
            print_r($e);
        } catch (\Throwable $throwable) {
            print_r($throwable);
        }
    }

    /**
     * @author: zzhpeng
     * Date: 2019/2/11
     * @param $class
     */
    final public static function autoLoader($class)
    {
        //把类转为目录，eg \a\b\c => /a/b/c.php
        $classPath = \str_replace('\\', DS, $class) . '.php';

        //约定框架类都在framework目录下, 业务类都在application下
        $findPath = [
//            self::$frameworkPath . DS,
            self::$applicationPath . DS,
        ];

        //遍历目录，查找文件
        foreach ($findPath as $path) {
            //如果找到文件，则require进来
            $realPath = $path . $classPath;
            if (is_file($realPath)) {
                require "{$realPath}";
//                var_dump($realPath);
                return;
            }
        }
//        exit;

    }

}