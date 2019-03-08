<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/22
 * Time: 9:23 PM
 */

namespace controller;


use service\Token;
use service\User;

class Auth extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if($this->isLogin()){
            return $this->failResponse('已登录');
        }

    }

    /**
     * 登录接口
     * @author: zzhpeng
     * Date: 2019/2/28
     * @return bool
     */
    public function login()
    {
        try{
            $param = $this->request->getRequestParam();
            if(!isset($param['phone']) || !isset($param['password'])){
                throw new \Exception('缺少参数');
            }
            $user = User::getInstance()->getInfo('phone = '.$param['phone']);

            if(!$user){
                throw new \Exception('账号不存在');
            }

            if ($user && $user->password == self::encryption($param['password']) ) {
                // 用户存在 修改登陆数据
                //生成token
                $token = Token::generateToken();
                $user->token = $token;
                $updata = [
                    'last_login_ip' => $this->request->getServerParams()['remote_addr'],
                    'login_count' => $user->login_count + 1,
                    'token' => $token,
                ];
                User::getInstance()->updateById($updata,$user->id);

                return $this->successResponse((array)$user);
            }else{
                throw new \Exception('账户或密码不正确');
            }
        }catch (\Exception $e){
            return $this->failResponse($e->getMessage());
        }

    }

    private static function encryption($value){
        return $value;
//        return md5($value);
    }

    protected function isLogin(){
        var_dump($this->request->getHeaders()["token"][0]);
        if(isset($this->request->getHeaders()['token'])){
            return true;
        };
        return false;
    }


}
