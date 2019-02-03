<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/2
 * Time: 8:17 PM
 */
namespace zzhpeng\mvc;

class Entity
{
    /**
     * Entity constructor.
     * @param array $array
     * @desc 把数组填充到entity
     */
    public function __construct(array $array)
    {
        if (empty($array)) {
            return $this;
        }

        foreach ($array as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}