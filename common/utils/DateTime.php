<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/12 0012
 * Time: 上午 8:36
 */

namespace app\common\utils;


class DateTime
{
    public static function now()
    {
        return date('Y-m-d H:i:s');
    }
}