<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/2
 * Time: 2:15 PM
 */
namespace zzhpeng\pool;

use zzhpeng\core\Singleton;
use zzhpeng\coroutine\Coroutine;

class Context
{
    use Singleton;
    /**
     * @var array context pool
     */
    private $pool = [];


    /**
     * @return \zzhpeng\coroutine\Context
     * @desc 可以任意协程获取到context
     */
    public function get()
    {
        $id = Coroutine::getPid();
        if (isset($this->pool[$id])) {
            return $this->pool[$id];
        }

        return null;
    }

    /**
     * @desc 清除context
     */
    public function clear()
    {
        $id = Coroutine::getPid();
        if (isset($this->pool[$id])) {
            unset($this->pool[$id]);
        }
    }

    /**
     * @param $context
     * @desc 设置context
     */
    public function set($context)
    {
        $id = Coroutine::getPid();
        $this->pool[$id] = $context;
    }

    public function getLength()
    {
        return count($this->pool);
    }
}