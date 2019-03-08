<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/2
 * Time: 8:16 PM
 */
namespace entity;
use zzhpeng\mvc\Entity;
class User extends Entity
{
    /**
     * 对应的数据库表名
     */
    const TABLE_NAME = 'user';
    /**
     * 主键字段名
     */
    const PK_ID = 'id';

    //以下对应的数据库字段名
    public $id;
    public $phone;
    public $password;
    public $nickname;
    public $avatar;
    public $sex;
    public $login_count;
    public $created_time;
    public $update_time;
    public $delete_time;
    public $birthday;
    public $last_login_ip;
    public $token;
}