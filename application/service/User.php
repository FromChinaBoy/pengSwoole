<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/3
 * Time: 10:38 AM
 */
namespace service;

use zzhpeng\core\Singleton;
use dao\User as UserDao;

class User extends BaseService
{
    use Singleton;

    protected $daoInstance;
    static $user_cookies_key = 'user_cookies_key';

    public function __construct()
    {
        $this->daoInstance = UserDao::getInstance();
        parent::__construct();
    }

    /**
     * @author: zzhpeng
     * Date: 2019/2/22
     * @param int $limit
     * @param int $page
     *
     * @desc 获取所有用户列表
     * @return mixed
     */
    public function getUserInfoList($limit = 20,$page = 1)
    {
        return $this->daoInstance->paginate($limit,$page);
    }

    /**
     * @param array $array
     * @return bool
     * @desc 添加一个用户
     */
    public function add(array $array)
    {
        return $this->daoInstance->add($array);
    }

    /**
     * @param array $array
     * @param $id
     * @return bool
     * @throws \Exception
     * @desc 按id更新一个用户
     */
    public function updateById(array $array, $id)
    {
        return $this->daoInstance->update($array, "id={$id}");
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     * @desc 按id删除用户
     */
    public function deleteById($id)
    {
        return $this->daoInstance->delete("id={$id}");
    }


}