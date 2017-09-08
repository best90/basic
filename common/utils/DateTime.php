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
    public function __construct()
    {
        date_default_timezone_set('PRC');
    }

    /**
     * @return string
     */
    public static function now($format='Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * @return string
     */
    public static function date($format = 'Y-m-d')
    {
        return date($format);
    }
}