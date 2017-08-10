<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/8/8
 * Time: 15:13
 */

namespace app\commands\crawlers;


class CrawlerConfig
{
    public static function getConfig($name)
    {
        return require_once(__DIR__.'/config/'.$name.'.php');
    }
}