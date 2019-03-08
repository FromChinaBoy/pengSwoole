<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/3
 * Time: 10:44 AM
 */

namespace zzhpeng\mvc;

use zzhpeng\helper\Template;
use zzhpeng\pool\Context;

class Controller
{
    protected $request;

    protected $template;
    const _CONTROLLER_KEY_ = '__CTR__';
    const _METHOD_KEY_ = '__METHOD__';

    public function __construct()
    {
        //通过context拿到$request, 再也不用担收数据错乱了
        $context = Context::getInstance()->get();
        $this->request = $context->getRequest();
        $this->respoense = $context->getResponse();
        $this->template = Template::getInstance()->template;
    }
}