<?php

namespace app\models\cms;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "b2b_news.crawl_site".
 *
 * @property int $site_id
 * @property string $site_code
 * @property string $site_name
 * @property string $site_url
 * @property string $remark
 * @property int $is_enable 是否可用： 1 可用 0不可用
 * @property string $create_time
 */
class CrawlSite extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'b2b_news.crawl_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_enable'], 'integer'],
            [['create_time'], 'safe'],
            [['site_code','site_name', 'site_url', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_id' => 'ID',
            'site_code' => '渠道简称',
            'site_name' => '渠道名称',
            'site_url' => '渠道网址',
            'remark' => '备注',
            'is_enable' => '生效',
            'create_time' => '创建时间',
        ];
    }
}
