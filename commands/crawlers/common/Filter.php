<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/8/10
 * Time: 9:22
 */

namespace app\commands\crawlers\common;


class Filter
{
    public static function htmlFilter($str)
    {
        $str = preg_replace("/\s+/", " ", $str); //过滤多余回车
        $str = preg_replace("/<[ ]+/si","<",$str); //过滤<__("<"号后面带空格)

        $str = preg_replace("/<\!--.*?-->/si","",$str); //注释
        $str = preg_replace("/<(\!.*?)>/si","",$str); //过滤DOCTYPE
        $str = preg_replace("/<(\/?html.*?)>/si","",$str); //过滤html标签
        $str = preg_replace("/<(\/?head.*?)>/si","",$str); //过滤head标签
        $str = preg_replace("/<(\/?meta.*?)>/si","",$str); //过滤meta标签
        $str = preg_replace("/<(\/?body.*?)>/si","",$str); //过滤body标签
        $str = preg_replace("/<(\/?link.*?)>/si","",$str); //过滤link标签
        $str = preg_replace("/<(\/?form.*?)>/si","",$str); //过滤form标签
        $str = preg_replace("/cookie/si","COOKIE",$str); //过滤COOKIE标签
        $str = preg_replace("/<a[ ](.*?)>/si","",$str); //过滤a标签
        $str = preg_replace("/<\/a>/si","",$str); //过滤a标签
        $str = preg_replace("/style=[\"].*?[\"]/si","",$str); //过滤style标签
        $str = preg_replace("/class=[\"].*?[\"]/si","",$str); //过滤class标签
        $str = preg_replace("/id=[\"].*?[\"]/si","",$str); //过滤id标签
        $str = preg_replace("/source_src=[\"](.*?)[\"]/si","",$str); //过滤id标签

        $str = preg_replace("/<(applet.*?)>(.*?)<(\/applet.*?)>/si","",$str); //过滤applet标签
        $str = preg_replace("/<(\/?applet.*?)>/si","",$str); //过滤applet标签

        $str = preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si","",$str); //过滤style标签
        $str = preg_replace("/<(\/?style.*?)>/si","",$str); //过滤style标签

        $str = preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si","",$str); //过滤title标签
        $str = preg_replace("/<(\/?title.*?)>/si","",$str); //过滤title标签

        $str = preg_replace("/<(object.*?)>(.*?)<(\/object.*?)>/si","",$str); //过滤object标签
        $str = preg_replace("/<(\/?objec.*?)>/si","",$str); //过滤object标签

        $str = preg_replace("/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si","",$str); //过滤noframes标签
        $str = preg_replace("/<(\/?noframes.*?)>/si","",$str); //过滤noframes标签

        $str = preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si","",$str); //过滤frame标签
        $str = preg_replace("/<(\/?i?frame.*?)>/si","",$str); //过滤frame标签

        $str = preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si","",$str); //过滤script标签
        $str = preg_replace("/<(\/?script.*?)>/si","",$str); //过滤script标签
        $str = preg_replace("/javascript/si","Javascript",$str); //过滤script标签
        $str = preg_replace("/vbscript/si","Vbscript",$str); //过滤script标签
        $str = preg_replace("/on([a-z]+)\s*=/si","On\\1=",$str); //过滤script标签
        $str = preg_replace("/&#/si","&＃",$str); //过滤script标签，如javAsCript:alert(
        $str = preg_replace("/<[ ]+/si","<",$str); //过滤<__("<"号后面带空格)
        $str = preg_replace("/[ ]+>/si",">",$str); //过滤<__(">"号前带空格)
        return $str;
    }
}