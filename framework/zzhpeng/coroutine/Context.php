<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/2
 * Time: 2:15 PM
 */
namespace zzhpeng\coroutine;

use EasySwoole\Http\Request;
use EasySwoole\Http\Response;

class Context
{
    /**
     * @var \swoole_http_request
     */
    private $request;
    /**
     * @var \swoole_http_response
     */
    private $response;
    /**
     * @var array 一个array，可以存取想要的任何东西
     */
    private $map = [];

    public function __construct(
        \swoole_http_request $request,
        \swoole_http_response $response)
    {
        $this->request = new Request($request);
        $this->response = new Response($response);
    }

    /**
     * @return \swoole_http_request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return \swoole_http_response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $key
     * @param $val
     */
    public function set($key, $val)
    {
        $this->map[$key] = $val;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }

        return null;
    }
}