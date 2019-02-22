<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2018/12/26
 * Time: 11:20 AM
 */
namespace controller;

use zzhpeng\mvc\Controller;
use service\User as UserService;

class Index extends BaseController
{
    public function index()
    {
        var_dump($this->request->getRequestParam('id','sd'));
        //通过context拿到$request, 再也不用担收数据错乱了
        return $this->template->render('index.twig', [
            'name' => 'tong'
        ]);
//        return 'i am family by route' . $this->request->getQueryParams()['uid'];
    }

    public function tong()
    {
        return 'i am tong ge';
    }

    /**
     * @return false|string
     * @throws \Exception
     * @desc 返回一个用户信息
     */
    public function user()
    {
        if (empty($this->request->get['uid'])) {
            throw new \Exception("uid 不能为空 ");
        }
        $result = UserService::getInstance()->getUserInfoByUId($this->request->get['uid']);
        return json_encode($result);

    }

    /**
     * @return false|string
     * @desc 返回用户列表
     */
    public function getlist()
    {
        $result = UserService::getInstance()->getUserInfoList();
        return $this->successResponse($result);

    }

    /**
     * @return bool
     * @desc 添加用户
     */
    public function add()
    {
        $array = [
            'user_name' => $this->request->getQueryParams()['name'],
            'password' =>$this->request->getQueryParams()['password'],
        ];

        return UserService::getInstance()->add($array);
    }

    /**
     * @return bool
     * @throws \Exception
     * @desc 更新用户信息
     */
    public function update()
    {
        $array = [
            'name' => $this->request->get['name'],
            'password' => $this->request->get['password'],
        ];
        $id = $this->request->get['id'];
        return UserService::getInstance()->updateById($array, $id);
    }

    /**
     * @return mixed
     * @throws \Exception
     * @desc 删除用户信息
     */
    public function delete()
    {
        $id = $this->request->get['id'];
        return UserService::getInstance()->deleteById($id);
    }

}