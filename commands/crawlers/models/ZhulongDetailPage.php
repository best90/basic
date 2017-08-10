<?php

namespace app\commands\crawlers\models;

use Yii;

/**
 * This is the model class for table "b2b_news.zhulong_detail_page".
 *
 * @property string $pid
 * @property string $page_url
 * @property int $is_crawled 是否已抓取
 * @property string $crawled_time 抓取时间
 * @property string $remark
 */
class ZhulongDetailPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b2b_news.zhulong_detail_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_url'], 'required'],
            [['is_crawled'], 'integer'],
            [['crawled_time'], 'safe'],
            [['page_url', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'page_url' => 'Page Url',
            'is_crawled' => 'Is Crawled',
            'crawled_time' => 'Crawled Time',
            'remark' => 'Remark',
        ];
    }
}
