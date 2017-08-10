<?php

namespace app\commands\crawlers\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "b2b_news.zhulong_group_list".
 *
 * @property int $gid
 * @property string $group_url
 * @property string $group_page_num 总页码
 * @property string $crawl_page_num 当前抓取页码
 * @property int $is_all_crawled 是否全部列表抓取完成
 * @property string $remark
 */
class ZhulongGroupList extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b2b_news.zhulong_group_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_page_num'], 'integer'],
            [['group_url', 'remark'], 'string', 'max' => 255],
            [['crawl_page_num','is_all_crawled'],'safe'],
            [['group_url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'group_url' => 'Group Url',
            'group_page_num' => 'Group Page Num',
            'crawl_page_num' => 'Crawl Page Num',
            'is_all_crawled' => 'Is All Crawled',
            'remark' => 'Remark',
        ];
    }
}
