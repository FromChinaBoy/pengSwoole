<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/3/8
 * Time: 4:44 PM
 */

namespace service;


use zzhpeng\core\Config;

class Token extends BaseService
{
    public static function generateToken(){
        //32随机字符组成
        $randChars = self::getRandChar(32);
        $timesstap = time();
        $salt = Config::get('secure')['token_salt'];
        return md5($randChars.$timesstap.$salt);
    }
//    public function getCurrentTokenVar($key){
//        $token = $this->request->getHeader()['token'];
//        if(!$token){
//            throw new \Exception('未携带token');
//        }
//        return $token;
////        $vars = Cache::get($token);
////        if(!$vars){
////            throw new TokenException();
////        }
////        if(!is_array($vars)){
////            $vars = json_decode($vars,true);
////        }
////        if(array_key_exists($key,$vars)){
////            return $vars[$key];
////        }else{
////            throw new Exception('尝试获取token变量值不存在');
////        }
//    }
//    public static function getCurrentUId(){
//        $uid = self::getCurrentTokenVar('uid');
//        return $uid;
//    }
//
//    //有权限
//    public static function needPrimaryScope(){
//        $scope = self::getCurrentTokenVar('scope');
//        if($scope){
//            if($scope >= ScopeEnum::user){
//                return true;
//            }else{
//                throw new ForbiddenException();
//            }
//        }else{
//            throw new TokenException();
//        }
//    }
//    //只能是用户权限，管理员不能进入
//    public static function needExclusiveScope(){
//        $scope = self::getCurrentTokenVar('scope');
//        if($scope){
//            if($scope == ScopeEnum::user){
//                return true;
//            }else{
//                throw new ForbiddenException();
//            }
//        }else{
//            throw new TokenException();
//        }
//    }
//    public static function isValidOperate($uid = ''){
//        if($uid != self::getCurrentUId()){
//            return false;
//        };
//        return true;
//    }
//    public static function verifyToken($token){
//        $result = Cache::get($token);
//        if($result){
//            return true;
//        }
//        return false;
//    }
}