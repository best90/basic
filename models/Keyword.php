<?php

namespace app\models;

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
class Keyword extends ActiveRecord
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
            [['keyword_length', 'is_valid'], 'integer'],
            [['create_time'], 'safe'],
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
            'keyword' => 'Keyword',
            'keyword_length' => 'Keyword Length',
            'url' => 'Url',
            'is_valid' => 'Is Valid',
            'create_time' => 'Create Time',
        ];
    }
}
