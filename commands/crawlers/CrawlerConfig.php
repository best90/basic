<?php

namespace app\commands\crawlers;


class CrawlerConfig
{
    public static function getConfig($name)
    {
        return require_once(__DIR__.'/config/'.$name.'.php');
    }
}