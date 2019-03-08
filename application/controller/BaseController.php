<?php
/**
 * Created by PhpStorm.
 * User: hiho
 * Date: 18-9-18
 * Time: 下午6:24
 */

namespace controller;

use zzhpeng\mvc\Controller;


class BaseController extends Controller
{
    use AjaxResponseTrait {
        successResponse as protected ajaxSuccessResponse;
    }

//    public function __construct(App $app = null)
//    {
//        try {
//            $appId = Request::param('app_id', null) . '';
//            $appSecret = Request::param('app_secret', null) . '';
//            $this->authCheck($appId, $appSecret);
//        } catch (\Exception $e) {
//            $this->failResponse($e->getMessage())->send();
//            exit;
//        }
//        parent::__construct($app);
//    }
    /**
     * 接口的appId和appSecret验证
     * @author hihozhou
     *
     * @param $appId
     * @param $appSecret
     */
    protected function authCheck(string $appId = null, string $appSecret = null)
    {
        $needCheck = env('API_SETTING.NEED_CHECK', true);
        if (!$needCheck) {
            return;
        }
        $settingAppId = env('API_SETTING.APP_ID');
        $settingAppSecret = env('API_SETTING.APP_SECRET');
        if (empty($settingAppId) || empty($settingAppSecret)) {
            throw new \Exception('系统接口未配置正确的app_id和app_secret');
        }
        if ($settingAppId != $appId || $settingAppSecret != $appSecret) {
            throw new \Exception('app_id或app_secret错误');
        }
    }

}