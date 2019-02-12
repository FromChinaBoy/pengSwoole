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
    const TABLE_NAME = 'users';
    /**
     * 主键字段名
     */
    const PK_ID = 'id';

    //以下对应的数据库字段名
    public $id;
    public $user_name;
    public $password;
}