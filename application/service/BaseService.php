<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/28
 * Time: 4:43 PM
 */

namespace service;

use zzhpeng\pool\Context;

class BaseService
{
    protected $daoInstance;

    public function __construct()
    {
        $context = Context::getInstance()->get();
        $this->request = $context->getRequest();
        $this->respoense = $context->getResponse();
    }
    /**
     * @author: zzhpeng
     * Date: 2019/2/28
     * @param string      $where
     * @param string      $fields
     * @param string|null $orderBy
     *
     * @return mixed
     */
    public function getInfo(string $where = '1', string $fields = '*', string $orderBy = null)
    {
        return $this->daoInstance->fetchEntity($where, $fields, $orderBy);
    }

    /**
     * @author: zzhpeng
     * Date: 2019/2/28
     * @param $id
     *
     * @return mixed
     */
    public function getInfoById($id)
    {
        return $this->daoInstance->fetchById($id);
    }

    /**
     * @author: zzhpeng
     * Date: 2019/3/8
     * @param $length
     *
     * @return null|string
     */
    public static function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
        for ($i=0;$i<$length;$i++){
            $str .= $strPol[rand(0,$max)];
        }
        return $str;
    }
}