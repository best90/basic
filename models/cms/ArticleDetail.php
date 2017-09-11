<?php

namespace app\models\cms;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "article_detail".
 *
 * @property int $uid 关联新闻表ID
 * @property string $detail 新闻内容
 * @property string $detail_view 添加内链关键词后的内容
 * @property integer $is_transform
 * @property string $transform_time
 */
class ArticleDetail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail', 'detail_view'], 'string'],
            [['uid','detail', 'detail_view','is_transform','transform_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'detail' => '正文',
            'detail_view' => '正文预览',
            'is_transform' => '是否处理',
            'transform_time' => '处理时间'
        ];
    }
}
