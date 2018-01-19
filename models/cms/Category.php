<?php

namespace app\models\cms;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "b2b_news.category".
 *
 * @property int $category_code 分类code
 * @property string $category_name 分类名称
 * @property int $parent_category_code 父分类code
 * @property int $is_show 是否显示
 * @property int $rank 排序：升序显示
 * @property string $last_modify_by
 * @property string $last_modify_time
 * @property string $create_by
 * @property string $create_time
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name','rank','is_show'],'required','message' => "{attribute}不能为空"],
            [['parent_category_code','rank','is_show'], 'integer'],
            [['last_modify_by', 'create_by','last_modify_time', 'create_time'], 'safe'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_code' => '分类ID',
            'category_name' => '* 分类名称',
            'parent_category_code' => '* 上级分类',
            'is_show' => '* 显示',
            'rank' => '* 排序',
            'last_modify_by' => '修改人',
            'last_modify_time' => '修改时间',
            'create_by' => '创建人',
            'create_time' => '创建时间',
        ];
    }
}
