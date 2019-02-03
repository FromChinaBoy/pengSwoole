<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/3
 * Time: 10:44 AM
 */

namespace zzhpeng\mvc;

use zzhpeng\pool\Context;

class Controller
{
    protected $request;

    public function __construct()
    {
        //通过context拿到$request, 再也不用担收数据错乱了
        $context = Context::getContext();
        $this->request = $context->getRequest();
    }
}