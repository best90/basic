<?php

namespace app\models\cms;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "keyword".
 *
 * @property string $id
 * @property string $keyword
 * @property integer $keyword_length
 * @property string $url
 * @property integer $is_valid
 * @property string $create_time
 */
class CrawlArticle extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword', 'url'], 'required','message'=>'{attribute}不能为为空'],
            [['keyword_length', 'is_valid','create_time'], 'safe'],
            [['keyword', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => '关键词',
            'keyword_length' => '关键词长度',
            'url' => '链接',
            'is_valid' => '生效',
            'create_time' => '创建时间',
        ];
    }
}
