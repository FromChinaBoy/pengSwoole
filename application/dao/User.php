<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/3
 * Time: 10:31 AM
 */

namespace dao;
use  zzhpeng\core\Singleton;
use zzhpeng\mvc\Dao;

class User extends Dao
{
    use Singleton;

    public function __construct()
    {
        parent::__construct('\entity\User');
    }
}