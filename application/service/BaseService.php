<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/28
 * Time: 4:43 PM
 */

namespace service;

class BaseService
{
    protected $daoInstance;

    public function __construct()
    {
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
}