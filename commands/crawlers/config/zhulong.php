<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/8/8
 * Time: 15:04
 */

$config = [
    'domain' => 'http://bbs.zhulong.com',
    'homePage' => [
        'url' => [
            'root' => 'div.tab-item ul li',
            'contains' => 'group', //url包含
            'rule' => [
                'find' => 'a',
                'attr' => 'href',
            ],
        ],
    ],
    'listPage' => [
        'url' => [
            'root' => '.zhul_zy_rtop',
            'contains' => 'detail',
            'rule' => [
                'find' => 'p.zhul_zy_rtit a',
                'attr' => 'href',
            ],
            //Url跳过提取过滤
            'strip' => [
                'find' => '.zhul_zy_wjgs img',
                'html' => 'html',
            ],
        ],
        //页码提取
        'page' => [
            'root' => '.zhul_qz_pageul .zhul_zr_pageHv_qd',
            'rule' => [
                'find' => 'span:last',
                'text' => 'text',
            ],
        ],
    ],
    'detailPage' => [
        'title' => [
            'rule' => [
                'find' => 'title',
                'text' => 'text',
            ],
        ],
        'tag' => [
            'rule' => [
                'find' => 'meta[name="keywords"]',
                'attr' => 'content',
            ]
        ],
        'digest' => [
            'rule' => [
                'find' => '#thread_title',
                'text' => 'text'
            ]
        ],
        'content' => [
            'rule' => [
                'find' => '.zhul_xx_content',
                'html' => 'html',
            ]
        ],
    ],
];

return $config;