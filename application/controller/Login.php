<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/22
 * Time: 9:40 PM
 */

namespace controller;


use service\User;

class Login
{


    public function login($phone, $password)
    {
        User::getInstance()->getUserInfoByUId($this->request->get['uid']);

        $user = $this->where('phone', '=', $phone)->find();
        if ($user && $user->password == md5($password)) {
            // 用户存在 修改登陆数据
            $updata = [
                // 'last_login_ip' => request()->ip(),
                'login_count' => $user->login_count + 1
            ];
            $this->save($updata, ['id' => $admin->id]);

            // $re->last_login_ip = $updata['last_login_ip'];
            $admin->login_count = $updata['login_count'];
            return $admin;
        }
        return false;
    }


    public function auth()
    {
        $data = $this->request(['account', 'password']);
        $validate = new \app\admin\validate\Login();
        if (!$validate->check($data)) {
            return $this->failResponse('登录失败:' . $validate->getError());
        }
        $UserAdmin = new Admin;
        $admin = $UserAdmin->login($data['account'], $data['password']);
        if ($admin) {
            if(!AdminLogic::checkIsSuperAdmin($admin)){
                $permissions = AdminRoleLogic::getPermissionList($admin->id);
                if ($permissions->isEmpty()) {
                    return $this->failResponse('该账号无权限');
                }
            }
            Auth::loginByUser($admin);
            return $this->successResponse(['url' => '/admin']);
        }
        return $this->failResponse('管理员账号或密码错误');
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        //清除menu缓存
        Auth::clearMenuCache();
        Auth::logout();

        $this->redirect(url('/admin/login'));
    }
}