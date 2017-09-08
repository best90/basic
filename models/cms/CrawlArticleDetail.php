<?php

namespace app\models\cms;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "crawl_article_detail".
 *
 * @property string $id
 * @property string $detail
 */
class CrawlArticleDetail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawl_article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'detail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail' => '内容详情',
        ];
    }
}
