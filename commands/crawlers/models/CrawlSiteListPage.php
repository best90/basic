<?php

namespace app\commands\crawlers\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "crawl_site_list_page".
 *
 * @property int $id
 * @property string $list_url
 * @property string $list_page_num 总页码
 * @property string $crawl_page_num 当前抓取页码
 * @property int $is_all_crawled 是否全部列表抓取完成
 * @property string $remark
 */
class CrawlSiteListPage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawl_site_list_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_page_num'], 'integer'],
            [['list_url', 'remark'], 'string', 'max' => 255],
            [['crawl_page_num','is_all_crawled'],'safe'],
            [['list_url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'list_url' => 'List Url',
            'list_page_num' => 'List Page Num',
            'crawl_page_num' => 'Crawl Page Num',
            'is_all_crawled' => 'Is All Crawled',
            'remark' => 'Remark',
        ];
    }
}
